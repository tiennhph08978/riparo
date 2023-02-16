<?php

namespace App\Jobs\Admin;

use App\Mail\Admin\StartProjectEmail;
use App\Models\ProjectUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendStartProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $project;
    public $emailTemplate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project, $emailTemplate)
    {
        $this->project = $project;
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $project = $this->project;

        Mail::to($project->user->email)->send(new StartProjectEmail($project->user, $project, $this->emailTemplate));

        foreach ($project->projectUsers as $projectUser) {
            if ($projectUser->status == ProjectUser::STATUS_APPROVED) {
                Mail::to($projectUser->user->email)->send(new StartProjectEmail($projectUser->user, $project, $this->emailTemplate));
            }
        }
    }
}
