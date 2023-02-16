<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $mailTemplate;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @param $mailTemplate
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
        return $this->view('user.mail.send', [
            'data' => $data,
            'mailTemplate' => $mailTemplate,
        ])->subject($mailTemplate['subject']);
    }
}
