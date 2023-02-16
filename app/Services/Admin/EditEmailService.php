<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\Email;
use App\Models\Admin;
use App\Services\Service;
use Response;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;

class EditEmailService extends Service
{
    /**
     * List emails
     *
     * @return array
     */
    public function list()
    {
        $results = Email::query()->whereNotIn('id', Email::MAIL_ADMIN);
        return $results->get();
    }

    /**
     * Get record theo id
     *
     * @param $id
     * @return array
     */
    public function detail($id)
    {
        $result = Email::where('id', $id)->first();
        return $result;
    }

    /**
     * Update email theo id
     *
     * @param $request , $id
     * @param $id
     * @return json
     */
    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $dataSave = [
                'subject' => $request->subject,
                'header' => $request->header,
                'content' => $request->content,
                'contact' => $request->contact,
            ];
            $email = Email::find($id)->update($dataSave);
            DB::commit();

            return $email;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * get receive_email admin
     *
     * @return  $result
     */
    public function receiveEmail()
    {
        $result = Admin::select('receive_email')->where('id', Auth::id())->first();
        return $result->receive_email;
    }

    /**
     * update receive_email admin
     *
     * @param $request
     * @return bool|null $data
     */
    public function updateReceiveEmail($request)
    {
        try {
            DB::beginTransaction();
            Auth::user()->update(['receive_email' => $request->receive_email]);
            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }
}
