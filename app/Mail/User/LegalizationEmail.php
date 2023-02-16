<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LegalizationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    public $emailTemplate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $emailTemplateLegalization)
    {
        $this->data = $mailData;
        $this->emailTemplate = $emailTemplateLegalization;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        return $this->view('user.mail.legalization', [
            'project' => $data['project'],
            'emailTemplate' => $this->emailTemplate,
        ])->subject(str_replace(['{no}', '{target_amount}'], [\App\Helpers\ProjectHelper::formatId($data['project']->id), $data['project']->target_amount], $this->emailTemplate->subject));
    }
}
