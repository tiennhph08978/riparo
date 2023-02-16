<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $emailTemplateUser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $emailTemplateUser)
    {
        $this->data = $data;
        $this->emailTemplateUser = $emailTemplateUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.ban_user', [
            'data' => $this->data,
            'emailTemplate' => $this->emailTemplateUser,
            ])->subject($this->emailTemplateUser->subject);
    }
}
