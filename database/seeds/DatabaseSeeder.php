<?php

use Illuminate\Database\Seeder;
use App\BusinessSetting;
use App\OtpConfiguration;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // BusinessSetting::create([
        //     'type' => 'bulkgate_sms',
        //     'value' => 1
        // ]);

        // OtpConfiguration::create([
        //     'type' => 'bulkgate_sms',
        //     'value' => 1
        // ]);

        User::create([
            'unique_id' => unique_code(9),
            'user_type' => 'BVU',
            'name' => "BVU MLM",
            'username' => "bvu.mlm",
            'first_name' => "BVU",
            'last_name' => 'MLM',
            'email' => 'bvu@worldcraft.com.ph',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password')
        ]);
    }
}
