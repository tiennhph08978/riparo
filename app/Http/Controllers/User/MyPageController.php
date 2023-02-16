<?php

namespace App\Http\Controllers\User;

use App\Helpers\UserHelper;
use App\Http\Requests\User\Mypage\UpdatePasswordRequest;
use App\Http\Requests\User\Mypage\UpdatePersonalRequest;
use App\Services\User\MyPageService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class MyPageController extends BaseController
{
    public function __construct()
    {
        $this->middleware($this->authMiddleware())->only([
            'index',
            'editPersonal',
            'editPassword',
            'updatePassword',
            'updatePersonal',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $user = $this->guard()->user();
        $projectFounder = MyPageService::getInstance()->getProjectFounder($user);
        $projectMember = MyPageService::getInstance()->getProjectMember($user);

        return view('user.my-page.index', [
            'user' => $user,
            'projectFounder' => $projectFounder,
            'projectMember' => $projectMember,
        ]);
    }

    public function editPersonal()
    {
        $user = $this->guard()->user();
        $cityName = UserHelper::getCityName($user->city);
        $user->birth = $user->birth ? Carbon::parse($user->birth)->isoFormat('Y年MM月DD日') : '1995年06月19日';

        return view('user.my-page.edit-personal', [
            'user' => $user,
            'cityName' => $cityName,
        ]);
    }

    public function updatePersonal(UpdatePersonalRequest $request)
    {
        $updateUser = $request->only([
            'first_name',
            'first_name_furigana',
            'last_name',
            'last_name_furigana',
            'avatar',
            'password',
            'phone_number',
            'post_code',
            'city',
            'address',
            'desc',
            'birth',
            'gender',
        ]);
        $imageFile = $request->file('avatar');
        $user = $this->guard()->user();
        MyPageService::getInstance()->withUser($user)->updatePersonal($updateUser, $imageFile);

        return redirect()->route('user.my_page.index')->with('success', trans('message.update_personal_success'));
    }

    public function editPassword()
    {
        return view('user.my-page.edit-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $newPassword = $request->new_password;
        $user = $this->guard()->user();
        MyPageService::getInstance()->withUser($user)->updatePassword($newPassword);

        return redirect()->back()->with('success', trans('message.update_pass_success'));
    }
}
