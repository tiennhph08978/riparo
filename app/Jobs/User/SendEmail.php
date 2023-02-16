<?php


namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $data;
    protected $mailTemplate;

    /**
     * Create a new job instance.
     *
     * @param $email
     * @param $data
     * @param $mailTemplate
     */
    public function __construct($email, $data, $mailTemplate)
    {
        $this->email = $email;
        $this->data = $data;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new \App\Mail\User\SendEmail($this->data, $this->mailTemplate));
    }
}
