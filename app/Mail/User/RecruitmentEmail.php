<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecruitmentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $mailTemplate;
    /**
     * Create a new message instance.
     *
     * @param $data
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
        return $this->view('user.mail.recruitment', [
            'data' => $data,
            'project' => $data['project'],
            'mailTemplate' => $mailTemplate,
        ])->subject($mailTemplate->subject);
    }
}
