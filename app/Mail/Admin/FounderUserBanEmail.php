<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FounderUserBanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailTemplate;
    public $project;
    public $userBan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailTemplate, $project, $userBan)
    {
        $this->emailTemplate = $emailTemplate;
        $this->project = $project;
        $this->userBan = $userBan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailTemplate = $this->emailTemplate;
        return $this->view('admin.mail.sendmail_to_founder_user_ban', [
            'emailTemplate' => $emailTemplate,
            'project' => $this->project,
            'fullName' => $this->userBan->first_name . ' ' . $this->userBan->last_name,
        ])->subject($emailTemplate->subject);
    }
}
