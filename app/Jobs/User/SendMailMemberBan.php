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

class SendMailMemberBan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $projectUser;
    public $emailTemplate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($projectUser, $emailTemplateBan)
    {
        $this->projectUser = $projectUser;
        $this->emailTemplate = $emailTemplateBan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->projectUser->user->email)->send(new MemberBanEmail($this->projectUser, $this->emailTemplate));
    }
}
