<?php

namespace App\Services\User;

use App\Helpers\ProjectHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\FileHelper;
use App\Helpers\StringHelper;
use App\Jobs\SendRecruitmentEmail;
use App\Jobs\User\SendCreateProjectEmail;
use App\Jobs\User\SendEmail;
use App\Jobs\User\SendEmailToFounder;
use App\Jobs\User\SendMailMemberBan;
use App\Jobs\User\SendMailMemberInterView;
use App\Jobs\User\SendMailToMemberApproved;
use App\Jobs\User\SendMailToMemberBan;
use App\Jobs\User\SendMailRecruitingToAdmin;
use App\Jobs\User\SendLegalizationEmailToAdmin;
use App\Jobs\User\SendToFounderCreateProjectMail;
use App\Models\Admin;
use App\Models\Cost;
use App\Models\Dedication;
use App\Models\Email;
use App\Models\Project;
use App\Models\ProjectAvailableDate;
use App\Models\ProjectUser;
use App\Models\Turnover;
use App\Models\User;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectService extends Service
{
    /**
     * List project
     *
     * @param $data
     * @param $agent
     * @return LengthAwarePaginator
     */
    public function list($data, $agent)
    {
        $user = $this->user;
        $projects = Project::query()->with(['contactPeriod', 'images', 'industries'])
            ->where('status', Project::STATUS_RECRUITING);

        if ($user) {
            $projects->with([
                'projectUsers' => function ($query) use ($user) {
                    return $query->where('user_id', $user->id)
                        ->whereIn('status', [ProjectUser::STATUS_PENDING, ProjectUser::STATUS_WAITING_INTERVIEW, ProjectUser::STATUS_APPROVED]);
                },
            ]);
        }

        if (isset($data['search'])) {
            $projects->where(function ($query) use ($data) {
                $query->where('title', 'LIKE', '%' . $data['search'] . '%')
                    ->orWhere('work_content', 'LIKE', '%' . $data['search'] . '%')
                    ->orWhere('special', 'LIKE', '%' . $data['search'] . '%');
            });
        }

        if (isset($data['industry_type'])) {
            $projects->whereHas('industries', function ($query) use ($data) {
                $query->where('industry_id', $data['industry_type']);
            });
        }

        if (isset($data['city_id'])) {
            $projects->where('city_id', $data['city_id']);
        }

        if (isset($data['filter_type'])) {
            $filterTypes = config('project.filter_map');
            if ($data['filter_type'] == $filterTypes['recent_time']) {
                $projects->orderBy('published_at', 'DESC');
            } elseif ($data['filter_type'] == $filterTypes['shortest_time']) {
                $projects->orderBy('m_contact_period_id', 'ASC');
            } else {
                $projects->orderBy('recruitment_number', 'DESC');
            }
        }

        if ($agent->isMobile()) {
            return $projects->orderBy('published_at', 'DESC')->paginate(config('validate.default_page_number_mobile'));
        }

        return $projects->orderBy('published_at', 'DESC')->paginate(config('validate.default_page_number'));
    }


    /**
     * @param $projects
     * @return string
     */
    public function listMobile($projects)
    {
        $projectRowHtml = '';

        foreach ($projects as $project) {
            $thumb = FileHelper::getFullUrl(@$project->images[0]->url);

            $projectRowHtml .= '<div class="row">' .
                '<div class="project-wrapper">' .
                '<div class="d-flex project-title-wrapper">' .
                '<div>' .
                '<img src="' . $thumb . '" alt="cover" class="project-thumb">' .
                '</div>' .
                '<div class="project-title">' .
                '<h3 class="title">' .
                '<span class="text-title">' . $project->title . '</span>';

            if (ProjectHelper::isNew($project)) {
                $projectRowHtml .= '<div class="div-new">' .
                    '<span class="new">' . trans('project.system.new') . '</span>' .
                    '</div>';
            }

            $projectRowHtml .= '</h3>' .
                '<div class="d-flex">' .
                '<p class="category mb-0">' . trans('project.attribute.industry') . ':</p>' .
                '<p class="category type mb-0">' . $project->industry . '</p>' .
                '</div>' .
                '</div>' .
                '</div>' .
                '<div class="project-info-wrapper">' .
                '<div class="project-info-col">' .
                '<div class="project-info-line">' .
                '<img src="' . asset('assets/img/project/people-icon.svg') . '" alt="cover" class="project-icon">' .
                '<p class="project-info-title">' . trans('project.attribute.recruitment_quantity') . ':' .
                '<span class="project-info-content">' . $project->recruitment_quantity_min . '人〜' . $project->recruitment_quantity_max . '人' .
                '</span>' .
                '</p>' .
                '</div>' .
                '<div class="project-info-line col-right">' .
                '<img src="' . asset('assets/img/project/time-icon.svg') .'" alt="time" class="project-icon">' .
                '<p class="project-info-title">' . trans('project.attribute.work_time') . ': <span class="project-info-content">' . $project->work_time . '</span></p>' .
                '</div>' .
                '</div>' .
                '<div class="project-info-col">' .
                '<div class="project-info-line">' .
                '<img src="' . asset('assets/img/project/percent-icon.svg') . '" alt="percent" class="project-icon">' .
                '<p class="project-info-title">' . trans('project.attribute.recruitment_quantity') . ':' .
                '<span class="project-info-content">' . $project->recruitment_number . '%' .
                '</span>' .
                '</div>' .
                '<div class="project-info-line col-right">' .
                '<img src="' . asset('assets/img/project/calendar-icon.svg') . '" alt="calendar" class="project-icon">' .
                '<p class="project-info-title">' . trans('project.attribute.contract_period_reach') . ':' .
                '<span class="project-info-content">' . $project->contactPeriod->name . '</span>' .
                '</p>' .
                '</div>' .
                '</div>' .
                '<div class="project-info-line">' .
                '<img src="' . asset('assets/img/project/location-icon.svg') .'" alt="location" class="project-icon">' .
                '<p class="project-info-title">' . trans('project.attribute.address') . ':' .
                '<span class="project-info-content">' . config('master_data.provinces.' . $project->city_id) . '</span>' .
                '<span class="project-info-content">' . $project->address . '</span>' .
                '</p>' .
                '</div>' .
                '<div class="project-info-line mb-0">' .
                '<img src="' . asset('assets/img/project/desc-icon.svg') . '" alt="desc" class="project-icon">' .
                '<p class="project-info-title">' . trans('project.attribute.work_content') . ': <span class="project-info-content">' . $project->work_content . '</span></p>' .
                '</div>' .
                '</div>' .
                '<div class="project-btn">' .
                '<a href="' . \App\Helpers\UrlHelper::getProjectUrl($project) . '" class="login-link p-link">' . trans('project.system.detail') . '</a>';


            if ($this->user) {
                if (\App\Helpers\ProjectHelper::getProjectRole($project, $this->user) == \App\Models\ProjectUser::ROLE_GUEST) {
                    $projectRowHtml .= '<a id="' . $project->id . '" href="' . '?recruitment-' . $project->id . '" class="p-btn recruitment-btn ' . 'project-' . $project->id . '">' . trans('project.system.recruitment') . '</a>' .
                    '<form id="recruitment-form-' . $project->id . '" action="' . \App\Helpers\UrlHelper::getProjectUrl($project) . '" method="post">' .
                    '<div class="recruitment-form ' . 'recruitment-' . $project->id . '">' .
                    '<div class="content">' .
                    '<span class="close">&times;</span>' .
                    '<h3>' . trans('project.system.apply') . '</h3>' .
                    '<div class="project-title">' .
                    '<h3 class="title">' .
                    '<div class="text-title">{{ $project->title }}</div>';

                    if (\App\Helpers\ProjectHelper::isNew($project)) {
                        $projectRowHtml .= '<span class="new">' . trans('project.system.new') . '</span>' .
                            '</h3>' .
                            '<div class="d-flex">' .
                            '<p class="m-0 category">' . trans('project.attribute.industry') . ':</p>' .
                            '<p class="m-0 category type">' . config('master_data.industries.' . $project->industry_type) . '</p>' .
                            '</div>' .
                            '</div>' .
                            '<div class="option">' .
                            '<div class="option-name">' . trans('project.system.interview') . '</div>' .
                            '<div class="select-option">' .
                            '<div class="position-relative">' .
                            '<input type="radio" name="request_type" value="0" checked>' .
                            '<span class="checkmark"></span>' .
                            '<span>' . trans('project.request_type.' . config('project.request_type.' . \App\Models\ProjectUser::REQUEST_TYPE_RESEARCH)) . '</span>' .
                            '</div>' .
                            '<div class="position-relative">' .
                            '<input type="radio" name="request_type" value="1">' .
                            '<span class="checkmark"></span>' .
                            '<span>' . trans('project.request_type.' . config('project.request_type.' . \App\Models\ProjectUser::REQUEST_TYPE_JOIN_NOW)) . '</span>' .
                            '</div>' .
                            '</div>' .
                            '</div>' .
                            '<div class="option pt-2">' .
                            '<div class="option-name">' . trans('project.system.contact') . '</div>' .
                            '<div class="select-option">' .
                            '<div class="position-relative">' .
                            '<input type="radio" name="contact_type" value="0" checked>' .
                            '<span class="checkmark"></span>' .
                            '<span>' . trans('project.contact_type.' . config('project.contact_type.' . \App\Models\ProjectUser::CONTACT_TYPE_EMAIL)) . '</span>' .
                            '</div>' .
                            '<div class="position-relative">' .
                            '<input type="radio" name="contact_type" value="1">' .
                            '<span class="checkmark"></span>' .
                            '<span>' . trans('project.contact_type.' . config('project.contact_type.' . \App\Models\ProjectUser::CONTACT_TYPE_PHONE)) . '</span>' .
                            '</div>' .
                            '<div class="position-relative">' .
                            '<input type="radio" name="contact_type" value="2">' .
                            '<span class="checkmark"></span>' .
                            '<span>' . trans('project.contact_type.' . config('project.contact_type.' . \App\Models\ProjectUser::CONTACT_TYPE_BOTH)) . '</span>' .
                            '</div>' .
                            '</div>' .
                            '</div>' .
                            '' .
                            '<button type="submit" class="btn btn-block">' .
                            '<img src="' . asset('assets/img/project/email-icon.svg') . '">' . trans('project.system.submit_form') . '' .
                            '</button>' .
                            '</div>' .
                            '</div>' .
                            '</form>';
                    }
                }
            } else {
                $projectRowHtml .= '<a href="' . route('user.auth.login') . '?next_page_url=' . route('user.project.list') . '?recruitment-' . $project->id . '" class="p-btn">' . trans('project.system.recruitment') . '</a>';
            }

            $projectRowHtml .= '</div>' .
                '</div>' .
                '</div>';
        }

        return $projectRowHtml;
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
        $project->load([
            'contracts' => function ($query) {
                $query->orderByDesc('created_at');
            },
        ]);
        $availableDate = $project->availableDate()->get();
        $availableDate = $availableDate->map(function ($date) {
            $date->date = Carbon::parse($date->date)->isoFormat('Y年MM月DD日');
            $date->startTime = Carbon::parse($date->start_time)->isoFormat('hh:mm');
            $date->endTime = Carbon::parse($date->end_time)->isoFormat('hh:mm');
            return $date;
        });
        $project->availableDateEdit = $availableDate;
        $user = $this->user;
        $projectUserPending = [];
        $projectUserApprove = [];
        $projectUserInterview = [];
        $projectUserEnd = [];
        if ($user) {
            $projectUserPending = $project->projectUsers()->where('status', ProjectUser::STATUS_PENDING)
                ->whereHas('user', function ($query) {
                    $query->where('status', User::STATUS_ACTIVATED);
                })->get();
            $projectUserInterview = $project->projectUsers()->where('status', ProjectUser::STATUS_WAITING_INTERVIEW)->get();
            $projectUserApprove = $project->projectUsers()->where('status', ProjectUser::STATUS_APPROVED)->get();
            $projectUserEnd = $project->projectUsers()->where('status', ProjectUser::STATUS_END)->get();
        }
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
        $totalTurnover = 0;
        foreach ($project->turnovers as $turnover) {
            $totalTurnover += ($turnover->quantity * $turnover->unit_price);
        }
        $project->totalTurnover = $totalTurnover;

        return [
            'project' => $project,
            'mainImage' => $project->images->shift(),
            'images' => $project->images->all(),
        ];
    }

    /**
     * Recruitment request to project
     *
     * @param $project
     * @param $data
     * @return mixed
     */
    public function postDetail($project, $data)
    {
        try {
            DB::beginTransaction();
            $mailUserTemplate = Email::where('type', Email::TYPE_RECRUITMENT_USER)->first();
            $mailAdminTemplate = Email::where('type', Email::TYPE_RECRUITMENT_ADMIN)->first();
            $firstName = User::where('id', $project->user_id)->first();

            $data = array_merge($data, [
                'user_id' => $this->user->id,
                'project_id' => $project->id,
                'status' => ProjectUser::STATUS_PENDING,
            ]);

            ProjectUser::create($data);

            $mailDataUser = [
                'project' => $project,
                'user' => auth()->user(),
                'user_id' => auth()->user()->id,
                'first_name' => auth()->user()->first_name,
            ];
            $mailData = [
                'project' => $project,
                'user' => $this->user,
                'user_id' => $this->user->id,
                'first_name' => $firstName->first_name,
            ];
            $mailUserTemplate->subject = str_replace('{no}', \App\Helpers\ProjectHelper::formatId($project->id), $mailUserTemplate->subject);
            dispatch(new SendEmail($this->user->email, $mailDataUser, $mailUserTemplate->toArray()))->onQueue(config('queue.email_queue'));
            $admins = Admin::all();
            $mailAdminTemplate->subject = str_replace('{no}', \App\Helpers\ProjectHelper::formatId($project->id), $mailAdminTemplate->subject);
            $mailAdminTemplate->content = str_replace('{no}', \App\Helpers\ProjectHelper::formatId($project->id), $mailAdminTemplate->content);
            $mailAdminTemplate->contact = str_replace('{url}', \App\Helpers\UrlHelper::getProjectAdminlink($project), trans('admin.footer.' . $mailAdminTemplate->id));

            foreach ($admins as $admin) {
                dispatch(new SendEmail($admin->receive_email, $mailData, $mailAdminTemplate->toArray()))->onQueue(config('queue.email_queue'));
            }
            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * create project
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = auth()->id();
            $user = auth()->user();
            $data = $this->convertDataProject($data);
            $project = Project::create($data);
            $project->industries()->attach($data['industry_type']);
            $project->availableDate()->createMany($data['available_date']);
            $project->images()->createMany($data['images']);
            $project->update(['no' => ProjectHelper::formatId($project->id)]);
            $emailTemplateCreateProject = Email::where('type', Email::TYPE_CREATE_PROJECT)->first();
            $emailTemplateCreateProjectFounder = Email::where('type', Email::TYPE_CREATE_PROJECT_FOUNDER)->first();
            $mailData = [
                'project' => $project,
                'user' => $user,
                'user_id' => auth()->id(),
                'first_name' => $user->first_name,
            ];

            dispatch(new SendCreateProjectEmail($mailData, $emailTemplateCreateProject))->onQueue(config('queue.email_queue'));
            dispatch(new SendEmailToFounder($mailData, $emailTemplateCreateProjectFounder))->onQueue(config('queue.email_queue'));

            DB::commit();
            return $project;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    protected function convertDataProject($project)
    {
        $diskName = config('upload.disk');
        $folderPrefix = config('upload.project_prefix');
        $availableDate = [];
        foreach ($project['available_date'] as $key => $value) {
            $availableDate[] = [
                'date' => Carbon::createFromFormat('Y年m月d日', $value)->toDateString(),
                'start_time' => Carbon::createFromFormat('Y年m月d日 H', $value . ' ' . $project['available_start_time'][$key])->toDateTimeString(),
                'end_time' => Carbon::createFromFormat('Y年m月d日 H', $value . ' ' . $project['available_end_time'][$key])->toDateTimeString(),
            ];
        }
        $project['available_date'] = $availableDate;
        $images = [];

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
     * Find detail project
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $project = Project::with(['banner', 'detailImages', 'industries', 'availableDate'])->find($id);
        if ($project) {
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
        return false;
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
            $dataSave = $data;
            $remove = ['industry_type', 'image_banner', 'images', 'image_detail', 'image_detail_id', 'available_date', 'available_start_time', 'available_end_time', 'available_id', 'check_recruitment'];
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
            $listData = [];
            $listDataNew = [];
            foreach ($data['available_date'] as $key => $value) {
                if ($data['available_id'][$key] === 'new') {
                    $listDataNew[] = $value;
                } else {
                    $listData[] = $data['available_id'][$key];
                    ProjectAvailableDate::where('id', $data['available_id'][$key])->update($value);
                }
            }
            ProjectAvailableDate::whereNotIn('id', $listData)->where('project_id', $id)->delete();
            $project->availableDate()->createMany($listDataNew);
            DB::commit();

            return $project;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * Recruiting project
     *
     * @param $id
     * @return mixed
     */
    public function recruiting($id)
    {
        try {
            DB::beginTransaction();
            $project = Project::find($id);
            $projectUserInterview = $project->projectUsers()->where('status', ProjectUser::STATUS_WAITING_INTERVIEW)->get();
            $projectUserPending = $project->projectUsers()->where('status', ProjectUser::STATUS_PENDING)->get();
            $emailTemplateBan = Email::where('type', Email::TYPE_MEMBER_BAN)->first();
            $emailTemplateApproved = Email::where('type', Email::TYPE_MEMBER_APPROVED)->first();
            $emailTemplateRecruiting = Email::where('type', Email::TYPE_RECRUITING_ADMIN)->first();

            dispatch(new SendMailToMemberBan($projectUserPending, $emailTemplateBan))->onQueue(config('queue.email_queue'));
            dispatch(new SendMailToMemberApproved($projectUserInterview, $emailTemplateApproved))->onQueue(config('queue.email_queue'));
            $mailData = [
                'project' => $project,
                'user' => $this->user,
            ];
            dispatch(new SendMailRecruitingToAdmin($mailData, $emailTemplateRecruiting))->onQueue(config('queue.email_queue'));

            if ($project->status === Project::STATUS_RECRUITING) {
                $project->update(['status' => Project::STATUS_ACTIVE]);
                $projectUserInterview->each->update(['status' => ProjectUser::STATUS_APPROVED]);
                $projectUserPending->each->delete();
            }
            DB::commit();

            return $project;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * GetDataSale project
     *
     * @param $data
     * @param $result
     * @return mixed
     */
    protected function getDataSale($data, $result)
    {
        $totalCost = 0;
        $costs = Cost::where('project_id', $data['project_id'])->get();
        $project = Project::find($data['project_id']);
        foreach ($costs as $value) {
            $totalCost += ($value->quantity * $value->unit_price);
        }
        $result['total_cost'] = number_format($totalCost);
        $totalTurnover = 0;
        $turnovers = Turnover::where('project_id', $data['project_id'])->get();
        foreach ($turnovers as $value) {
            $totalTurnover += ($value->quantity * $value->unit_price);
        }
        $result['total_turnover'] = number_format($totalTurnover);
        $result['total_sale'] = number_format($totalTurnover - $totalCost);
        $result['total_sale_note'] = trans('project.profit.contract_period_reach_2', [
            'value' => StringHelper::formatMoney(($project->target_amount - ($totalTurnover - $totalCost)) > 0 ? ($project->target_amount - ($totalTurnover - $totalCost)) : 0),
        ]);
        return $result;
    }

    /**
     * UpdateCost project
     *
     * @param $data
     * @return mixed
     */
    public function updateCost($data)
    {
        try {
            DB::beginTransaction();
            $data['date'] = Carbon::createFromFormat('Y年m月d日', $data['date'])->toDateString();
            if ($data['id']) {
                $cost = Cost::where('id', $data['id'])->update($data);
                if (!$cost) {
                    DB::commit();
                    return false;
                }
                $cost = $data;
            } else {
                $cost = Cost::create($data);
            }
            $cost['date'] = Carbon::parse($cost['date'])->isoFormat('Y年MM月DD日');
            $cost['total'] = number_format($cost['quantity'] * $cost['unit_price']);
            $cost['quantity'] = number_format($cost['quantity']);
            $cost['unit_price'] = number_format($cost['unit_price']);
            $cost = $this->getDataSale($data, $cost);
            DB::commit();

            return $cost;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * UpdateCost project
     *
     * @param $data
     * @param $projectId
     * @return mixed
     */
    public function deleteCost($data, $projectId)
    {
        try {
            DB::beginTransaction();
            $dataDelete = Cost::where('id', $data['id'])->delete();
            $cost = ['status' => $dataDelete];
            $cost = $this->getDataSale(['project_id' => $projectId], $cost);
            DB::commit();

            return $cost;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }
    /**
     * UpdateTurnover project
     *
     * @param $data
     * @return mixed
     */
    public function updateTurnover($data)
    {
        try {
            DB::beginTransaction();
            $data['date'] = Carbon::createFromFormat('Y年m月d日', $data['date'])->toDateString();
            if ($data['id']) {
                $turnover = Turnover::where('id', $data['id'])->update($data);
                if (!$turnover) {
                    DB::commit();
                    return false;
                }
                $turnover = $data;
            } else {
                $turnover = Turnover::create($data);
            }
            $turnover['date'] = Carbon::parse($turnover['date'])->isoFormat('Y年MM月DD日');
            $turnover['total'] = number_format($turnover['quantity'] * $turnover['unit_price']);
            $turnover['quantity'] = number_format($turnover['quantity']);
            $turnover['unit_price'] = number_format($turnover['unit_price']);
            $turnover = $this->getDataSale($data, $turnover);
            DB::commit();

            return $turnover;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * UpdateTurnover project
     *
     * @param $data
     * @param $projectId
     * @return mixed
     */
    public function deleteTurnover($data, $projectId)
    {
        try {
            DB::beginTransaction();
            $dataDelete = Turnover::where('id', $data['id'])->delete();
            $turnover = ['status' => $dataDelete];
            $turnover = $this->getDataSale(['project_id' => $projectId], $turnover);
            DB::commit();

            return $turnover;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * ListDedication project
     *
     * @param $userId
     * @param $projectId
     * @return mixed
     */
    public function listDedication($userId, $projectId)
    {
        $dedications = Dedication::where('user_id', $userId)->where('project_id', $projectId)->get();
        $dedications = $dedications->map(function ($dedication) {
            $dedication->date = DateTimeHelper::formatDateJapan($dedication->date);
            return $dedication;
        });
        return $dedications;
    }


    /**
     * UpdateDedication project
     *
     * @param $data
     * @return mixed
     */
    public function updateDedication($data)
    {
        try {
            DB::beginTransaction();
            $data['date'] = Carbon::createFromFormat('Y年m月d日', $data['date'])->toDateString();
            if ($data['id']) {
                $dedication = Dedication::where('id', $data['id'])->update($data);
                if (!$dedication) {
                    DB::commit();
                    return false;
                }
                $dedication = $data;
            } else {
                $data['is_member_check'] = Dedication::CHECK_PENDING;
                $data['is_founder_check'] = Dedication::CHECK_PENDING;
                $dedication = Dedication::create($data);
            }
            $dedication['date'] = Carbon::parse($dedication['date'])->isoFormat('Y年MM月DD日');
            DB::commit();

            return $dedication;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * UpdateDedication project
     *
     * @param $data
     * @return mixed
     */
    public function updateDedicationCheck($data)
    {
        try {
            DB::beginTransaction();
            $dedication = Dedication::where('id', $data['id'])->update($data);
            DB::commit();
            if (!$dedication) {
                return false;
            }
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * DeleteDedication project
     *
     * @param $data
     * @param $projectId
     * @return mixed
     */
    public function deleteDedication($data, $projectId)
    {
        try {
            DB::beginTransaction();
            $dataDelete = Dedication::where('id', $data['id'])->delete();
            $totalDedication = 0;
            $dedications = Dedication::where('project_id', $projectId)->get();
            foreach ($dedications as $value) {
                $totalDedication += ($value->quantity * $value->unit_price);
            }
            $dedication['total_dedication'] = number_format($totalDedication);
            DB::commit();

            return ['status' => $dataDelete, 'total_dedication' => number_format($totalDedication) ];
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
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
            $projectUser = ProjectUser::find($projectUserId);
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

            return $projectUser->user;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    public function rejectProjectUser($projectUserId)
    {
        try {
            DB::beginTransaction();

            $projectUser = ProjectUser::find($projectUserId);
            $projectUser->delete();
            $emailTemplateBan = Email::where('type', Email::TYPE_MEMBER_BAN)->first();
            dispatch(new SendMailMemberBan($projectUser, $emailTemplateBan))->onQueue(config('queue.email_queue'));
            $projectUser->user->avatar = $projectUser->user->avatar ? FileHelper::getFullUrl($projectUser->user->avatar) : asset('assets/img/icon_user.svg');
            DB::commit();

            return $projectUser->user;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * Send email legalization
     *
     * @param $id
     * @return RedirectResponse
     */
    public function legalization($id)
    {
        try {
            DB::beginTransaction();
            $project = Project::find($id);
            if ($project->result != Project::RESULT_LEGALIZATION) {
                $project->update(['result' => Project::RESULT_LEGALIZATION]);
                $emailTemplateLegalization = Email::where('type', Email::TYPE_LEGALIZATION)->first();
                $mailData = [
                    'project' => $project,
                    'user' => $this->user,
                ];
                dispatch(new SendLegalizationEmailToAdmin($mailData, $emailTemplateLegalization))->onQueue(config('queue.email_queue'));
            }
            DB::commit();

            return $project;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }
}
