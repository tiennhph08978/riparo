<?php

namespace App\Services\User;

use App\Helpers\StringHelper;
use App\Models\Project;
use App\Models\User;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MyPageService extends Service
{
    /**
     * get data projet with founder
     *
     *
     * @param object $user
     */
    public function getProjectFounder(object $user)
    {
        $projects = Project::where('user_id', $user->id)->orderByDesc('projects.id')->get();

        return $projects;
    }

    /**
     * get data project with member
     *
     *
     * @param $user
     */
    public function getProjectMember($user)
    {
        $projects = Project::with([
                'projectUsers' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                },
            ])
            ->whereHas('projectUsers', function ($q) use ($user) {
                $q->where('project_users.user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->orderByDesc('projects.id')
            ->get();

        return $projects;
    }

    public function updatePassword($newPassword)
    {
        try {
            DB::beginTransaction();
            $this->user->update([
                'password' => Hash::make($newPassword),
            ]);
            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }

    public function updatePersonal($updateUser, $imageFile)
    {
        try {
            DB::beginTransaction();
            $updateUser['post_code'] = str_replace('-', '', $updateUser['post_code']);
            $updateUser['city'] = array_search($updateUser['city'], config('master_data.provinces'));
            $updateUser['birth'] = Carbon::createFromFormat('Y年m月d日', $updateUser['birth'])->toDateString();
            if ($imageFile) {
                $diskName = config('upload.disk');
                $folderPrefix = config('upload.avatar_prefix');
                $imageName = 'avatar-' . StringHelper::uniqueCode(30) . '.' . $imageFile->getClientOriginalExtension();
                Storage::disk($diskName)->putFileAs($folderPrefix, $imageFile, $imageName);
                $updateUser['avatar'] = $folderPrefix . $imageName;
            }

            $use = User::findOrFail($this->user->id);
            $use->update($updateUser);
            DB::commit();

            return $updateUser;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }
}
