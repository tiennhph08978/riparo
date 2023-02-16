<?php

namespace App\Jobs;

use App\Mail\User\ForgotPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $emailTemplate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $emailTemplate)
    {
        $this->data = $data;
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $emailTemplate = $this->emailTemplate;
        Mail::to($data['email'])->send(new ForgotPasswordMail($data, $emailTemplate));
    }
}
