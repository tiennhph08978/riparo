<?php


namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToFounder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $mailTemplate;

    /**
     * Create a new job instance.
     *
     * @param $email
     * @param $data
     * @param $mailTemplate
     */
    public function __construct($data, $mailTemplate)
    {
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
        $data = $this->data;
        $mailTemplate = $this->mailTemplate;
        $founder = $data['project']->founder;
        Mail::to($founder->email)->send(new \App\Mail\User\SendEmailToFounder($data, $mailTemplate));
    }
}
