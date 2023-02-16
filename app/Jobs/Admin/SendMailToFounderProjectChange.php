<?php

namespace App\Jobs\Admin;

use App\Mail\Admin\FounderProjectChangeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailToFounderProjectChange implements ShouldQueue
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
        Mail::to($this->project->user->email)->send(new FounderProjectChangeEmail($this->project, $this->emailTemplate));
    }
}
