<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends BaseController
{

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    /**
     * getViewAdminIndex.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(Request $request)
    {
        return redirect()->to(route('admin.manager-user.index'));
    }
}
