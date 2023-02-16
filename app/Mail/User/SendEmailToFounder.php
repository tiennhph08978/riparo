<?php

namespace App\Mail\User;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailToFounder extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $mailTemplate;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $mailTemplate
     */
    public function __construct($data, $mailTemplate)
    {
        $this->data = $data;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $mailTemplate = $this->mailTemplate;
        return $this->view('user.mail.send_to_founder', [
          'data' => $data,
          'project' => $data['project'],
          'mailTemplate' => $mailTemplate,
          'footer' => trans('admin.footer.' . Email::TYPE_CREATE_PROJECT_FOUNDER),
        ])->subject(str_replace('{no}', \App\Helpers\ProjectHelper::formatId($data['project']->id), $mailTemplate->subject));
    }
}
