<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Email;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Email::truncate();
        $emails = [];
        foreach (trans('admin.subjects') as $key => $value) {
            $emails[] = [
                'id' => $key,
                'subject' => $value,
                'header' => trans('admin.header'),
                'content' => trans('admin.contents')[$key],
                'contact' => trans('admin.contact'),
                'type' => $key,
            ];
        }
        Email::insert($emails);
    }
}
