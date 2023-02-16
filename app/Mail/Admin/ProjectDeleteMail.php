<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectDeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $projectId;
    public $emailTemplate;
    public $firstName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projectId, $firstName, $emailTemplate)
    {
        $this->projectId = $projectId;
        $this->firstName = $firstName;
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.project_delete', [
            'projectId' => $this->projectId,
            'firstName' => $this->firstName,
            'emailTemplate' => $this->emailTemplate,
        ])->subject($this->emailTemplate->subject);
    }
}
