<?php

namespace App\Jobs\User;

use App\Mail\User\LegalizationEmail;
use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLegalizationEmailToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    public $emailTemplate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailData, $emailTemplateLegalization)
    {
        $this->data = $mailData;
        $this->emailTemplate = $emailTemplateLegalization;
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
            Mail::to($admin->receive_email)->send(new LegalizationEmail($data, $this->emailTemplate));
        }
    }
}
