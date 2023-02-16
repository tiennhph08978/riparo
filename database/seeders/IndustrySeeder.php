<?php

namespace Database\Seeders;

use App\Models\Industry;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Industry::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $industries = [];
        foreach (config('master_data.industries') as $key => $value) {
            $industries[] = [
                'id' => $key,
                'name' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        Industry::insert($industries);
    }
}
