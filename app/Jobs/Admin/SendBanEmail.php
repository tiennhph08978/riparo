<?php

namespace App\Jobs\Admin;

use Illuminate\Bus\Queueable;
use App\Mail\Admin\BanEmail;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBanEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $emailTemplateUser;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $emailTemplateUser)
    {
        $this->data = $data;
        $this->emailTemplateUser =$emailTemplateUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;

        Mail::to($data['email'])->send(new BanEmail($data, $this->emailTemplateUser));
    }
}
