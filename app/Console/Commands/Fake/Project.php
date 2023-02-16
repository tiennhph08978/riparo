<?php

namespace App\Console\Commands\Fake;

use App\Console\Kernel;
use App\Helpers\ProjectHelper;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Provider\Image;
use Faker\Provider\Lorem;
use Exception;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Category;
use App\Models\Project as ModelProject;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\Image as ModelImage;
use Illuminate\Support\Str;

class Project extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = Kernel::CMD_FAKE_PROJECT;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fake projects';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $qty = $this->option('qty');
        if (!$qty || $qty == 0) {
            return 0;
        }

        $userIds = User::query()->where('status', User::STATUS_ACTIVATED)
            ->pluck('id')->toArray();
        if (count($userIds) == 0) {
            $this->comment('[CMD] Warn: No users found!');
            return 0;
        }

        $factory = Factory::create(config('app.locale'));
        $cityCount = count(config('master_data.provinces'));
        $industryCount = count(config('master_data.industries'));
        $fakerContent = new Lorem($factory);
        $fakeImageUrl = new Image($factory);

        for ($i = 0; $i <= $qty; $i++) {
            try {
                DB::beginTransaction();
                $projects = [
                    'title' => $fakerContent->text(rand(20, 50)),
                    'user_id' => Arr::random($userIds),
                    'industry_type' => rand(1, $industryCount),
                    'city_id' => rand(1, $cityCount),
                    'address' => $fakerContent->text(rand(20, 32)),
                    'contract_period_reach' => rand(1, 6),
                    'recruitment_quantity' => '{"from":"3","to":"6"}',
                    'recruitment_number' => rand(1, 10),
                    'work_time' => $fakerContent->text(rand(20, 50)),
                    'work_content' => $fakerContent->text(rand(100, 255)),
                    'work_desc' => $fakerContent->text(rand(500, 1000)),
                    'special' => $fakerContent->text(rand(500, 1000)),
                    'business_development_incorporation' => $fakerContent->text(rand(500, 1000)),
                    'employment_incorporation' => $fakerContent->text(rand(500, 1000)),
                    'available_date' => '{"1":{"date":"18/8/2020","from":"10:00","to":"18:00"}}',
                    'status' => Arr::random([
                        ModelProject::STATUS_PENDING,
                        ModelProject::STATUS_RECRUITING,
                        ModelProject::STATUS_ACTIVE,
                        ModelProject::STATUS_END,
                    ]),
                ];
                $newProject = ModelProject::create($projects);

                $images = [];
                for ($j = 0; $j < rand(1, 3); $j++) {
                    $images[] = [
                        'imageable_type' => get_class($newProject),
                        'imageable_id' => $newProject->id,
                        'url' => $fakeImageUrl->imageUrl(810, 540),
                        'thumb' => $fakeImageUrl->imageUrl(810, 540),
                        'type' => 'image',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                ModelImage::insert($images);

                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                $this->error($exception->getMessage());
                return 0;
            }
        }
        $this->info('[SUCCESS] Fake project');

        return 0;
    }
}
