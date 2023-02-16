<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailureProjectEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $project;
    public $emailTemplate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $project, $emailTemplate)
    {
        $this->user = $user;
        $this->project = $project;
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.failure_project', [
            'user' => $this->user,
            'project' => $this->project,
            'emailTemplate' => $this->emailTemplate,
        ])->subject($this->emailTemplate->subject);
    }
}
