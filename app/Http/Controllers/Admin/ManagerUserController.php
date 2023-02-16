<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\ManagerUserService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class ManagerUserController extends BaseController
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    /**
     * Get list user va list user theo parameter
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(Request $request)
    {
        $search = $request->get('search');
        $results = ManagerUserService::getInstance()->list($search);

        return view(
            'admin.manager_user.index',
            [
                'results' => $results,
                'search' => $search,
            ]
        );
    }

    /**
     * Get detail theo user_id
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function detail(Request $request)
    {
        $result = ManagerUserService::getInstance()->detail($request);
        $result['user']->birth = $result['user']->birth ? Carbon::parse($result['user']->birth)->isoFormat('Y年MM月DD日') : '1995年06月19日';
        $statusText = [
            1 => trans('admin.status_project.pending'),
            2 => trans('admin.status_project.waiting'),
            3 => trans('admin.status_project.approved'),
            4 => trans('admin.status_project.end'),
        ];

        return view('admin.user_detail.index', compact('result', 'statusText'));
    }

    /**
     * Update status user
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function update($id)
    {
        $result = ManagerUserService::getInstance()->update($id);

        return redirect()->back()->with('success', trans('admin.modal.success'));
    }

    /**
     * Update status user
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function updateUser(Request $request, $id)
    {
        $result = ManagerUserService::getInstance()->updateUser($request->only('memo'), $id);

        return response()->json(['status' => true, 'message' => trans('message.update_success')]);
    }
}
