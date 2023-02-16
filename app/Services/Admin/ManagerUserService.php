<?php

namespace App\Services\Admin;

use App\Jobs\Admin\SendMailToFounderUserBan;
use App\Models\Email;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\Service;
use Mail;
use App\Jobs\Admin\SendBanEmail;
use Response;
use Illuminate\Support\Facades\DB;

class ManagerUserService extends Service
{
    /**
     * List user
     *
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list($search)
    {
        $results = User::query()->with([
            'projects' => function ($query) {
                $query->where('projects.status', '!=', Project::STATUS_END);
            },
            'projectUsers' => function ($query) {
                $query->where('project_users.status', '=', ProjectUser::STATUS_APPROVED)
                    ->where('project_users.deleted_at', '=', null);
            },
        ]);

        if ($search) {
            $results->where(function ($query) use ($search) {
                $query->where('email', 'LIKE', '%' . $search . '%')
                    ->orWhereRaw("concat(first_name, ' ', last_name) like '%" .$search. "%' ")
                    ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('projectUsers', function ($query) use ($search) {
                        $query->where('project_users.status', '=', ProjectUser::STATUS_APPROVED)
                            ->where('project_users.deleted_at', '=', null)
                            ->where('projects.title', 'LIKE', '%' . $search . '%');
                    });
            });
        }
        return $results->paginate(config('validate.default_page_number'));
    }

    /**
     * Detail user
     *
     * @param $id
     * @return object
     */
    public function detail($id)
    {
        $id = $id->route('id');
        $user = User::where('id', $id)->first();

        $projects = Project::with([
                'projectUsers' => function ($query) use ($id) {
                    $query->where('user_id', $id);
                },
            ])
            ->whereHas('projectUsers', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->orWhere('user_id', $id)
            ->orderBy('id')
            ->get();

        $result = [
            'user' => $user,
            'projects' => $projects,
        ];

        return $result;
    }

    /**
     * Update status user
     *
     * @param $id
     * @return mixed
     */
    public function update($idUserBan)
    {
        DB::beginTransaction();
        try {
            $projectUsers = ProjectUser::query();

            $userBan = User::query()->find($idUserBan);

            if ($userBan->status == User::STATUS_ACTIVATED) {
                $userBan->status = User::STATUS_INACTIVATED;
                $userBan->tokens()->where('id', $idUserBan)->delete();
                $userBan->save();

                $userProjects = $projectUsers->where('user_id', $idUserBan)
                    ->whereIn('status', [ProjectUser::STATUS_APPROVED, ProjectUser::STATUS_WAITING_INTERVIEW])
                    ->get();

                $idProjects = $userProjects
                    ->pluck('project_id')
                    ->toArray();

                $projects = Project::query()->with('user')
                    ->whereIn('id', $idProjects)
                    ->get();

                $emailTemplate = Email::where('type', Email::TYPE_USER_BAN)->first();

                $emailUser = [
                    'first_name' => $userBan->first_name,
                    'email' => $userBan->email,
                ];

                $emailTemplateUser = Email::where('type', Email::TYPE_TO_USER_BAN)->first();
                dispatch(new SendBanEmail($emailUser, $emailTemplateUser))->onQueue(config('queue.email_queue'));
                dispatch(new SendMailToFounderUserBan($projects, $emailTemplate, $userBan))->onQueue(config('queue.email_queue'));

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update user
     *
     * @param $id
     * @return mixed
     */
    public function updateUser($data, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::query()->find($id);
            $user->update($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }
}
