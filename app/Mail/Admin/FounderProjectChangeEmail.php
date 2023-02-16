<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FounderProjectChangeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $emailTemplate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project, $emailTemplate)
    {
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
        return $this->view('admin.mail.to_founder_project_change', [
            'project' => $this->project,
            'emailTemplate' => $this->emailTemplate,
        ])->subject($this->emailTemplate->subject);
    }
}
