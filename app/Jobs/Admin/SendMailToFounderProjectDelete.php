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

class SendMailToFounderProjectDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $project;
    public $mailTemplate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project, $mailTemplate)
    {
        $this->project = $project;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->project->user->email)->send(new ProjectDeleteMail($this->project->id, $this->project->user->first_name, $this->mailTemplate));
    }
}
