<?php

namespace App\Services\Admin;

use App\Helpers\FileHelper;
use App\Helpers\ProjectHelper;
use App\Helpers\StringHelper;
use App\Jobs\Admin\SendMailToFounderMemberBan;
use App\Jobs\Admin\SendMailToFounderProjectChange;
use App\Jobs\Admin\SendMailToFounderProjectDelete;
use App\Jobs\Admin\SendMailToMemberBan;
use App\Jobs\Admin\SendMailToMemberProjectDelete;
use App\Jobs\Admin\SendPublishProject;
use App\Jobs\Admin\SendStartProject;
use App\Jobs\User\SendMailMemberBan;
use App\Jobs\User\SendMailMemberInterView;
use App\Models\Admin;
use App\Models\Contract;
use App\Models\Dedication;
use App\Models\Email;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectService extends Service
{
    protected const RESULT_LEGALIZATION = 5;
    protected const RESULT_DISSOLUTION = 6;

    /**
     * Project list
     *
     * @param $data
     * @return LengthAwarePaginator
     */
    public function index($data)
    {
        $projects = Project::query();

        if (isset($data['search'])) {
            $projects->where(function ($query) use ($data) {
                return $query->where('id', 'LIKE', '%' . $data['search'] . '%')
                    ->orWhere('title', 'LIKE', '%' . $data['search'] . '%')
                    ->orWhere('no', 'LIKE', '%' . $data['search'] . '%');
            });
        }

        if (isset($data['status']) && $data['status'] != 0) {
            $projects->where('status', $data['status']);
        }

        return $projects->paginate(config('validate.default_page_number'));
    }

    /**
     * Detail project
     *
     * @param $project
     * @return array
     */
    public function detail($project)
    {
        $project->load(['banner', 'contactPeriod', 'availableDate', 'projectUsers', 'contracts']);
        $availableDate = $project->availableDate()->get();
        $availableDate = $availableDate->map(function ($date) {
            $date->date = Carbon::parse($date->date)->isoFormat('Y年MM月DD日');
            $date->startTime = Carbon::parse($date->start_time)->isoFormat('hh:mm');
            $date->endTime = Carbon::parse($date->end_time)->isoFormat('hh:mm');
            return $date;
        });
        $project->availableDateEdit = $availableDate;
        $projectUserPending = $project->projectUsers()->where('status', ProjectUser::STATUS_PENDING)
            ->whereHas('user', function ($query) {
                $query->where('status', User::STATUS_ACTIVATED);
            })->get();
        $projectUserInterview = $project->projectUsers()->where('status', ProjectUser::STATUS_WAITING_INTERVIEW)->get();
        $projectUserApprove = $project->projectUsers()->where('status', ProjectUser::STATUS_APPROVED)->get();
        $projectUserEnd = $project->projectUsers()->where('status', ProjectUser::STATUS_END)->get();
        $project->projectUserPending = $projectUserPending;
        $project->projectUserInterview = $projectUserInterview;
        $project->projectUserApprove = $projectUserApprove;
        $project->projectUserEnd = $projectUserEnd;
        $checkBeforeEnd = false;
        if (count($availableDate)) {
            $now = Carbon::now()->valueOf();
            $project->startMiliTime = Carbon::parse($project->start_date)->valueOf();
            $project->endMiliTime = Carbon::parse($project->end_date)->valueOf();
            $dateRange = (($project->endMiliTime - $project->startMiliTime) > 0 ? ($project->endMiliTime - $project->startMiliTime) : 0);
            $onTime = (($now - $project->startMiliTime) > 0 ? ($now- $project->startMiliTime) : 0);
            $checkBeforeEnd = $onTime >= ($dateRange * 0.75);
        }
        $totalCost = 0;
        foreach ($project->costs as $cost) {
            $totalCost += ($cost->quantity * $cost->unit_price);
        }
        $project->checkBeforeEnd = ($project->status === Project::STATUS_ACTIVE) ? $checkBeforeEnd : false;
        $project->endDate = Carbon::parse($project->end_date)->isoFormat('MM/DD hh:mm');
        $project->emailAdmin = Admin::first()->email;
        $project->totalCost = $totalCost;
        $isProjectUserContract = $project->projectUsers->where('participation_status', ProjectUser::PARTICIPATION_STATUS_CONTACT)->first();

        return [
            'project' => $project,
            'projectUsers' => $project->projectUsers->whereIn('status', [
                ProjectUser::STATUS_WAITING_INTERVIEW,
                ProjectUser::STATUS_APPROVED,
                ProjectUser::STATUS_END,
            ]),
            'mainImage' => $project->images->shift(),
            'images' => $project->images->all(),
            'contracts' => $project->contracts,
            'startDate' => Carbon::parse($project->start_date)->format('Y-m-d'),
            'endDate' => Carbon::parse($project->end_date)->format('Y-m-d'),
            'endDateEditFormat' => $project->end_date ? Carbon::parse($project->end_date)->format('Y/m/d'): '',
            'isProjectUserContract' => $isProjectUserContract,
        ];
    }

    /**
     * Delete project
     *
     * @param $project
     * @return mixed
     */
    public function destroy($project)
    {
        try {
            DB::beginTransaction();
            $projectUsers = $project->projectUsers;
            $project->projectUsers()->delete();
            $project->dedications()->delete();
            $project->costs()->delete();
            $project->turnovers()->delete();
            $project->delete();

            $emailTemplate = Email::where('type', Email::TYPE_DELETE_PROJECT)->first();
            dispatch(new SendMailToFounderProjectDelete($project, $emailTemplate))->onQueue(config('queue.email_queue'));
            dispatch(new SendMailToMemberProjectDelete($projectUsers, $emailTemplate))->onQueue(config('queue.email_queue'));
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Upload image contract
     *
     * @param $project
     * @param $file
     * @return mixed
     */
    public function uploadContract($project, $file)
    {
        try {
            DB::beginTransaction();
            $destinationPath = 'public/contracts';
            $pdfName = FileHelper::constructPdfFileName();

            $file->storeAs($destinationPath, $pdfName);
            $projectId = $project->id;
            $contract = Contract::query()->where('project_id', $projectId)->latest('created_at')->first();

            Contract::create([
                'project_id' => $projectId,
                'name' => $pdfName,
                'origin_name' => $file->getClientOriginalName(),
            ]);
            DB::commit();

            return [
                'name_file' => $file->getClientOriginalName(),
                'contract_old' => $contract,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Kick member
     *
     * @param $project
     * @param $user
     * @return mixed
     */
    public function kickMember($project, $user)
    {
        try {
            DB::beginTransaction();
            $projectUser =  ProjectUser::query()->where('project_id', $project->id)
                ->where('user_id', $user->id)->first();

            $emailTemplateBan = Email::where('type', Email::TYPE_MEMBER_BAN)->first();
            $emailTemplate = Email::where('type', Email::TYPE_USER_BAN)->first();
            dispatch(new SendMailToMemberBan($projectUser, $emailTemplateBan))->onQueue(config('queue.email_queue'));
            dispatch(new SendMailToFounderMemberBan($project, $emailTemplate, $user))->onQueue(config('queue.email_queue'));

            $projectUser->delete();
            Dedication::query()->where('project_id', $project->id)
                ->where('user_id', $user->id)
                ->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * User dedications
     *
     * @param $project
     * @param $userId
     * @return array
     */
    public function userDedications($project, $userId)
    {
        if ($userId == 0) {
            return $userDedications = $project->dedications->where('project_id', $project->id);
        }

        return $userDedications = $project->dedications->where('user_id', $userId)
            ->where('project_id', $project->id);
    }

    /**
     * Change status project
     *
     * @param $project
     * @return array
     */
    public function changeStatus($project)
    {
        try {
            DB::beginTransaction();
            $currentStatus = $project->status;
            $result = ProjectHelper::getTotalProfit($project);

            if ($currentStatus == Project::STATUS_PENDING) {
                $project->update([
                    'status' => Project::STATUS_RECRUITING,
                    'published_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                DB::commit();

                return ['status' => true, 'message' => '「' . $project->title  . '」' . trans('project.system.notify_publish_project')];
            }
            if ($project->status == Project::STATUS_RECRUITING) {
                if ($project->contracts->count()) {
                    $endDate = Carbon::now()->addDays($project->contactPeriod->day);
                    $project->update([
                        'status' => Project::STATUS_ACTIVE,
                        'start_date' => Carbon::now(),
                        'end_date' => $endDate,
                    ]);
                    $projectUsers = $project->projectUsers->where('status', ProjectUser::STATUS_WAITING_INTERVIEW);
                    $projectUsers->each->update([
                        'status' => ProjectUser::STATUS_APPROVED,
                        'participation_status' => ProjectUser::PARTICIPATION_STATUS_ACTIVE,
                    ]);
                    $mailTemplate = Email::where('type', Email::TYPE_START_PROJECT)->first();
                    dispatch(new SendStartProject($project, $mailTemplate))->onQueue(config('queue.email_queue'));
                    DB::commit();
                    return ['status' => true, 'message' => '「' . $project->title . '」' . trans('project.system.notify_start_project')];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => trans('message.error_no_contract')];
                }
            }
            if ($currentStatus == Project::STATUS_ACTIVE) {
                if ($result) {
                    $project->update([
                        'status' => Project::STATUS_END,
                        'result' => Project::RESULT_LEGALIZATION,
                        'end_date' => Carbon::now(),
                    ]);
                    $project->projectUsers->each->update(['status' => ProjectUser::STATUS_END]);
                    $mailTemplate = Email::where('type', Email::TYPE_SUCCESSFUL_PROJECT)->first();
                    $message = '「' . $project->title . '」' . trans('project.system.notify_successful_project');
                } else {
                    $project->update([
                        'status' => Project::STATUS_END,
                        'result' => Project::RESULT_DISSOLUTION,
                        'end_date' => Carbon::now(),
                    ]);
                    $project->projectUsers->each->update(['status' => ProjectUser::STATUS_END]);
                    $mailTemplate = Email::where('type', Email::TYPE_FAILURE_PROJECT)->first();
                    $message = '「' . $project->title . '」' . trans('project.system.notify_failure_project');
                }
                dispatch(new SendStartProject($project, $mailTemplate))->onQueue(config('queue.email_queue'));
                DB::commit();
                return ['status' => true, 'message' => $message];
            }
            DB::commit();

            return ['status' => false, 'message' => trans('message.error')];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => trans('message.error')];
        }
    }

    public function changeStatusAboutRecruiting($project)
    {
        try {
            DB::beginTransaction();
            $currentStatus = $project->status;

            if ($project->status == Project::STATUS_RECRUITING) {
                $project->update([
                    'status' => Project::STATUS_PENDING,
                ]);
                DB::commit();

                return Project::STATUS_PENDING;
            }
            if ($currentStatus == Project::STATUS_ACTIVE) {
                $project->update([
                    'status' => Project::STATUS_RECRUITING,
                    'result' => null,
                    'end_date' => null,
                ]);
                DB::commit();
                return Project::STATUS_RECRUITING;
            }
            if ($currentStatus == Project::STATUS_END) {
                $project->update([
                    'status' => Project::STATUS_ACTIVE,
                    'result' => null,
                    'end_date' => Carbon::now(),
                ]);
                DB::commit();
                return Project::STATUS_ACTIVE;
            }
            DB::commit();

            return ['status' => false, 'message' => trans('message.error')];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => trans('message.error')];
        }
    }

    /**
     * Find deatail project
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $project = Project::with(['banner', 'detailImages', 'industries', 'availableDate'])->find($id);
        $industries = $project->industries()->get();
        $project->industry_type = count($industries) ? $industries->pluck('id')->toArray() : [];
        $availableDate = $project->availableDate()->get();
        $availableDate = $availableDate->map(function ($date) {
            $date->date = Carbon::parse($date->date)->isoFormat('Y年MM月DD日');
            $date->startTime = Carbon::parse($date->start_time)->hour;
            $date->endTime = Carbon::parse($date->end_time)->hour;

            return $date;
        });
        $project->availableDateEdit = $availableDate;

        return $project;
    }

    /**
     * Update project
     *
     * @param $data
     * @return mixed
     */
    public function update($data, $id)
    {
        try {
            DB::beginTransaction();
            $data = $this->convertDataProject($data);
            $projectOld = Project::select(
                'title',
                'city_id',
                'address',
                'm_contact_period_id',
                'recruitment_quantity_min',
                'recruitment_quantity_max',
                'recruitment_number',
                'work_time',
                'work_content',
                'work_desc',
                'special',
                'business_development_incorporation',
                'employment_incorporation'
            )->where('id', $id)->first()->toArray();
            $projectWith = Project::with('industries', 'user')->where('id', $id)->first();
            $industryIds = $projectWith->industries()->pluck('industry_id')->toArray();

            $dataSave = $data;
            $remove = ['industry_type', 'image_banner', 'images', 'image_detail', 'image_detail_id', 'check_recruitment'];
            $dataSave = array_diff_key($dataSave, array_flip($remove));

            Project::where('id', $id)->update($dataSave);
            $project = Project::find($id);
            $project->industries()->detach();
            $project->industries()->attach($data['industry_type']);
            if ($data['images']) {
                foreach ($data['images'] as $image) {
                    if ($image['type'] === 'banner') {
                        $project->banner()->update($image);
                    }
                    if ($image['type'] === 'detail') {
                        if ($image['id']) {
                            $imageDetail = $project->detailImages()->where('id', $image['id'])->first();
                            unset($image['id']);
                            if ($imageDetail) {
                                $imageDetail->update($image);
                            } else {
                                $project->images()->createMany([$image]);
                            }
                        } else {
                            $project->images()->createMany([$image]);
                        }
                    }
                }
            }

            if (($project->status === Project::STATUS_ACTIVE) && ($data['m_contact_period_id'] != $project->m_contact_period_id)) {
                $endDate = Carbon::now()->addDays($project->contactPeriod->day);
                $project->update([
                    'end_date' => $endDate,
                ]);
            }
            DB::commit();

            return $project;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    protected function convertDataProject($project)
    {
        $availableDate = [];
        if (@$project['available_date']) {
            foreach ($project['available_date'] as $key => $value) {
                $availableDate[] = [
                'date' => Carbon::createFromFormat('Y年m月d日', $value)->toDateString(),
                'start_time' => Carbon::createFromFormat('Y年m月d日 H', $value . ' ' . $project['available_start_time'][$key])->toDateTimeString(),
                'end_time' => Carbon::createFromFormat('Y年m月d日 H', $value . ' ' . $project['available_end_time'][$key])->toDateTimeString(),
                ];
            }
            $project['available_date'] = $availableDate;
        }
        $images = [];
        $diskName = config('upload.disk');
        $folderPrefix = config('upload.project_prefix');
        if (@$project['image_banner']) {
            $imageName = 'banner-' . StringHelper::uniqueCode(30) . '.' . $project['image_banner']->getClientOriginalExtension();

            Storage::disk($diskName)->putFileAs($folderPrefix, $project['image_banner'], $imageName);
            $images[] = [
                'url' => $folderPrefix . $imageName,
                'thumb' => $folderPrefix . $imageName,
                'type' => 'banner',
            ];
        }
        if (@$project['image_detail']) {
            foreach ($project['image_detail'] as $key => $detailFile) {
                $imageName = 'detail-' . StringHelper::uniqueCode(30) . '.' . $detailFile->getClientOriginalExtension();
                Storage::disk($diskName)->putFileAs($folderPrefix, $detailFile, $imageName);
                $images[] = [
                    'id' => $project['image_detail_id'][$key],
                    'url' => $folderPrefix . $imageName,
                    'thumb' => $folderPrefix . $imageName,
                    'type' => 'detail',
                ];
            }
        }
        $project['images'] = $images;

        return $project;
    }

    /**
     * Update end date
     *
     * @param $project
     * @param $date
     * @return mixed
     */
    public function endDateUpdate($project, $date)
    {
        try {
            DB::beginTransaction();
            $project =  $project->update(['end_date' => Carbon::parse($date)->endOfDay()]);
            DB::commit();

            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * UpdateStatusProjectUser project
     *
     * @param $projectUserId
     * @param $status
     * @return mixed
     */
    public function updateStatusProjectUser($projectUserId, $data)
    {
        try {
            DB::beginTransaction();
            $projectUser = ProjectUser::with(['user', 'projects'])->find($projectUserId);
            ProjectUser::where('id', $projectUserId)->update($data);
            if (isset($data['status'])) {
                $emailTemplateBan = Email::where('type', Email::TYPE_MEMBER_BAN)->first();
                $emailTemplateApproved = Email::where('type', Email::TYPE_MEMBER_APPROVED)->first();
                if ($data['status'] == ProjectUser::STATUS_END) {
                    dispatch(new SendMailMemberBan($projectUser, $emailTemplateBan))->onQueue(config('queue.email_queue'));
                }

                if ($data['status'] == ProjectUser::STATUS_WAITING_INTERVIEW) {
                    dispatch(new SendMailMemberInterView($projectUser, $emailTemplateApproved))->onQueue(config('queue.email_queue'));
                }
            }
            $projectUser->user->avatar = $projectUser->user->avatar ? FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg');
            DB::commit();

            return $projectUser;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    public function rejectProjectUser($projectUserId)
    {
        try {
            DB::beginTransaction();

            $projectUser = ProjectUser::with(['user', 'projects'])->find($projectUserId);
            $projectUser->delete();
            $emailTemplateBan = Email::where('type', Email::TYPE_MEMBER_BAN)->first();
            dispatch(new SendMailMemberBan($projectUser, $emailTemplateBan))->onQueue(config('queue.email_queue'));
            $projectUser->user->avatar = $projectUser->user->avatar ? FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg');
            DB::commit();

            return $projectUser;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }
}
