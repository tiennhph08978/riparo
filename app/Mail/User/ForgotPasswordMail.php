<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected $emailTemplate;
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
        return $this->view('user.mail.forgot-password', [
                    'data' => $this->data,
                    'emailTemplate' => $this->emailTemplate,
                    ])->subject($this->emailTemplate['subject']);
    }
}
