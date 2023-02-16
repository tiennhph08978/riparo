<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberBanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $projectUser;
    public $emailTemplate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projectUser, $emailTemplate)
    {
        $this->projectUser = $projectUser;
        $this->emailTemplate =$emailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user.mail.member-ban', [
            'projectUser' => $this->projectUser,
            'emailTemplate' => $this->emailTemplate,
        ])->subject(str_replace('{no}', \App\Helpers\ProjectHelper::formatId($this->projectUser->project_id), $this->emailTemplate->subject));
    }
}
