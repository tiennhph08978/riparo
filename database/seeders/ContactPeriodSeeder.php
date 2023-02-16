<?php

namespace Database\Seeders;

use App\Models\ContactPeriod;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ContactPeriod::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $periods = [];
        foreach (config('master_data.periods') as $key => $value) {
            $periods[] = [
                'id' => $key,
                'name' => $value,
                'day' => config('project.contract_period_reach_day')[$key],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        ContactPeriod::insert($periods);
    }
}
