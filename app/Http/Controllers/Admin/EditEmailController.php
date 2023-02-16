<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\EditEmailService;
use App\Http\Requests\Admin\ReceiveEmailRequest;
use App\Http\Requests\Admin\EmailFormRequest;
use Illuminate\Http\Request;

class EditEmailController extends BaseController
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
     * @return Application|Factory|View
     */
    public function list()
    {
        $results = EditEmailService::getInstance()->list();
        return view('admin.edit_email.index', compact('results'));
    }

    /**
     * Get record theo id
     *
     * @param $id
     * @return array
     */
    public function detail($id)
    {
        $result = EditEmailService::getInstance()->detail($id);
        return $result;
    }

    /**
     * Update email theo id
     *
     * @param EditEmailService $request, $id
     * @return json
     */
    public function update(EmailFormRequest $request, $id)
    {
        $result = EditEmailService::getInstance()->update($request, $id);
        if ($result === true) {
            return response()->json(['success' => trans('admin.edit_email.success')]);
        } else {
            return redirect()->back()->withInput()->withErrors($request->errors);
        }
    }

    /**
     * get receive_email admin
     *
     * @return Application|Factory|View
     */
    public function receiveEmail()
    {
        $result = EditEmailService::getInstance()->receiveEmail();
        return view('admin.edit_email.receive_email', [
            'result' => $result,
        ]);
    }

    /**
     * update receive_email admin
     *
     * @param ReceiveEmailRequest $request
     * @return json
     */
    public function updateReceiveEmail(ReceiveEmailRequest $request)
    {
        $result = EditEmailService::getInstance()->updateReceiveEmail($request);
        if ($result === true) {
            return redirect()->back()->with('success', trans('admin.edit_email.receive_email_success'));
        }
        return redirect()->back()->withInput()->withErrors($request->errors);
    }
}
