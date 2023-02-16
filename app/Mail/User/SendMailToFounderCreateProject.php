<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToFounderCreateProject extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    public $emailTemplate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $emailTemplate)
    {
        $this->data = $data;
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;

        return $this->view('user.mail.create_project_to_founder', [
            'data' => $data,
            'project' => $data['project'],
            'emailTemplate' => $this->emailTemplate,
        ])->subject(str_replace('{no}', \App\Helpers\ProjectHelper::formatId($data['project']->id), $this->emailTemplate->subject));
    }
}
