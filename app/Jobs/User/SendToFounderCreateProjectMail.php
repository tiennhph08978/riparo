<?php

namespace App\Jobs\User;

use App\Mail\User\SendMailToFounderCreateProject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendToFounderCreateProjectMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    public $emailTemplate;

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

        Mail::to($data['email'])->send(new SendMailToFounderCreateProject($data, $this->emailTemplate));
    }
}
