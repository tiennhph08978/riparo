<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateCompleteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $emailTemplateCreateProject;

    /**
     * Create a new message instance.
     *
     * @param $data, $emailTemplateCreate
     */
    public function __construct($data, $emailTemplateCreateProject)
    {
        $this->data = $data;
        $this->emailTemplate = $emailTemplateCreateProject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        return $this->view('user.mail.create_project', [
            'project' => $data['project'],
            'emailTemplate' => $this->emailTemplate,
        ])->subject(str_replace('{no}', \App\Helpers\ProjectHelper::formatId($data['project']->id), $this->emailTemplate->subject));
    }
}
