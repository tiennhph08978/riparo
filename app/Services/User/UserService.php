<?php

namespace App\Services\User;

use App\Helpers\FileHelper;
use App\Models\User;
use App\Services\Service;

class UserService extends Service
{
    /**
     * Detail project
     *
     * @param $id
     * @return array
     */
    public function detail($id)
    {
        $user = User::find($id);
        $user->avatar = $user->avatar ? FileHelper::getFullUrl($user->avatar) : asset('assets/img/icon_user.svg');
        $user->full_address = $user->full_address;
        return $user;
    }
}
