<?php


namespace App\Jobs;

use App\Mail\User\RecruitmentEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRecruitmentEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $mailTemplate;
    /**
     * Create a new job instance.
     *
     * @param $data
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
        Mail::to($founder->email)->send(new RecruitmentEmail($data, $mailTemplate));
    }
}
