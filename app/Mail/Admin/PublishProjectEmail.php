<?php

namespace App\Mail\Admin;

use App\Helpers\ProjectHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PublishProjectEmail extends Mailable
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
        return $this->view('admin.mail.publish_project', [
            'project' => $this->project,
            'emailTemplate' => $this->emailTemplate,
        ])->subject(str_replace(['{no}'], [ProjectHelper::formatId($this->project->id)], $this->emailTemplate->subject));
    }
}
