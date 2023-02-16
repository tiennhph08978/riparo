<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailRecruitingToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $emailTemplateRecruiting)
    {
        $this->data = $mailData;
        $this->emailTemplate = $emailTemplateRecruiting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        return $this->view('user.mail.recruiting', [
            'project' => $data['project'],
            'emailTemplate' => $this->emailTemplate,
        ])->subject(str_replace('{no}', \App\Helpers\ProjectHelper::formatId($data['project']->id), $this->emailTemplate->subject));
    }
}
