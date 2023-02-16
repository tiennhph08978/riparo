<?php

namespace App\Jobs\User;

use App\Mail\User\CreateCompleteEmail;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCreateProjectEmail implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $data;
    public $emailTemplate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $emailTemplateCreateProject)
    {
        $this->data = $data;
        $this->emailTemplate = $emailTemplateCreateProject;
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
            Mail::to($admin->receive_email)->send(new CreateCompleteEmail($data, $this->emailTemplate));
        }
    }
}
