<?php

namespace App\Jobs\User;

use App\Mail\User\MailRecruitingToAdmin;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class SendMailRecruitingToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    public $emailTemplate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailData, $emailTemplateRecruiting)
    {
        $this->data = $mailData;
        $this->emailTemplate = $emailTemplateRecruiting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $admins = Admin::all();
        foreach ($admins as $admin) {
            Mail::to($admin->receive_email)->send(new MailRecruitingToAdmin($data, $this->emailTemplate));
        }
    }
}
