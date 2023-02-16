<?php

namespace App\Console\Commands;

use App\Jobs\Admin\SendStartProject;
use App\Models\Email;
use App\Models\Project;
use App\Models\ProjectUser;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailyCheckProjectEndCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily check project';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $projects = Project::with(['costs', 'turnovers', 'projectUsers'])->where('status', Project::STATUS_ACTIVE)->get();
        $now = Carbon::now();
        foreach ($projects as $project) {
            $totalCost = 0;
            $costs = $project->costs;
            foreach ($costs as $value) {
                $totalCost += ($value->quantity * $value->unit_price);
            }
            $result['total_cost'] = number_format($totalCost);
            $totalTurnover = 0;
            $turnovers = $project->turnovers;
            foreach ($turnovers as $value) {
                $totalTurnover += ($value->quantity * $value->unit_price);
            }
            if (($totalTurnover - $totalCost) >= Project::MAX_SALE) {
                $project->update([
                    'status' => Project::STATUS_END,
                    'result' => Project::RESULT_LEGALIZATION,
                    'end_date' => $now,
                ]);
                $project->projectUsers->each->update(['status' => ProjectUser::STATUS_END]);
                $mailTemplate = Email::where('type', Email::TYPE_SUCCESSFUL_PROJECT)->first();
                dispatch(new SendStartProject($project, $mailTemplate))->onQueue(config('queue.email_queue'));
            } elseif ($project->end_date <= $now) {
                $project->update(['status' => Project::STATUS_END]);
                $project->projectUsers->each->update(['status' => ProjectUser::STATUS_END]);
                $mailTemplate = Email::where('type', Email::TYPE_FAILURE_PROJECT)->first();
                dispatch(new SendStartProject($project, $mailTemplate))->onQueue(config('queue.email_queue'));
            }
        }
    }
}
