<?php

namespace App\Jobs\Admin;

use App\Mail\Admin\FounderUserBanEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToFounderUserBan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $projects;
    public $emailTemplate;
    public $userBan;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($projects, $emailTemplate, $userBan)
    {
        $this->projects = $projects;
        $this->emailTemplate = $emailTemplate;
        $this->userBan = $userBan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->projects as $project) {
            Mail::to($project->user->email)->send(new FounderUserBanEmail($this->emailTemplate, $project, $this->userBan));
            sleep(1);
        }
    }
}
