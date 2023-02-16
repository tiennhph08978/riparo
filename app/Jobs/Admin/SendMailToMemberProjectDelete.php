<?php

namespace App\Jobs\Admin;

use App\Mail\Admin\ProjectDeleteMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToMemberProjectDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $projectUsers;
    public $emailTemplate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($projectUsers, $emailTemplate)
    {
        $this->projectUsers = $projectUsers;
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->projectUsers as $projectUser) {
            Mail::to($projectUser->user->email)->send(new ProjectDeleteMail($projectUser->project_id, $projectUser->user->first_name, $this->emailTemplate));
            sleep(1);
        }
    }
}
