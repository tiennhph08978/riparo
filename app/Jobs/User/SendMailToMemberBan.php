<?php

namespace App\Jobs\User;

use App\Mail\User\MemberBanEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToMemberBan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $projectUsers;
    public $emailTemplate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($projectUserPending, $emailTemplateBan)
    {
        $this->projectUsers = $projectUserPending;
        $this->emailTemplate = $emailTemplateBan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->projectUsers as $projectUser) {
            Mail::to($projectUser->user->email)->send(new MemberBanEmail($projectUser, $this->emailTemplate));
            sleep(1);
        }
    }
}
