<?php

namespace App\Console\Commands\Fake;

use App\Console\Kernel;
use Faker\Provider\Image;
use Carbon\Carbon;
use Faker\Provider\Lorem;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Models\User as ModelUser;
use Faker\Factory;
use Illuminate\Support\Str;
use Faker\Provider\Person;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = Kernel::CMD_FAKE_USER;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fake user';

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

        $factory = Factory::create(config('app.locale'));
        $cityCount = count(config('master_data.provinces'));
        $fakerContent = new Lorem($factory);
        $fakerName = new Person($factory);
        $fakeImageUrl = new Image($factory);
        $users = [];

        for ($i = 0; $i < $qty; $i++) {
            $firstName = trim($fakerName->firstName());
            $lastName = trim($fakerName->lastName());
            $users[] = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'first_name_furigana' => $firstName,
                'last_name_furigana' => $lastName,
                'email' => Str::lower($firstName . rand(1, 1000)) . '@riparo.com',
                'avatar' => $fakeImageUrl->imageUrl(480, 480),
                'password' => Hash::make('123456xX@'),
                'phone_number' => '0' . rand(100000000, 999999999),
                'post_code' => rand(1000000, 2000000),
                'city' => rand(1, $cityCount),
                'address' => $fakerContent->text(rand(10, 32)),
                'desc' => $fakerContent->text(rand(30, 99)),
                'status' => Arr::random([
                    ModelUser::STATUS_ACTIVATED,
                    ModelUser::STATUS_INACTIVATED,
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        ModelUser::insert($users);
        $this->info('[SUCCESS] Fake user');

        return 0;
    }
}
