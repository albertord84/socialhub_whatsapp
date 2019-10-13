<?php

use App\Models\User;
use App\Models\UsersAttendant;
use App\Models\UsersManager;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Users Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users_managers')->truncate();
        DB::table('users_attendants')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Create Users:');

        $faker = new Faker();
        User::create([
            'company_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@socialhub.pro',
            'login' => 'admin',
            'role_id' => 1,
            'status_id' => 1,
            'password' => bcrypt('admin'),
        ]);
        $this->command->info('Admin created: [user: admin@socialhub.pro, pass: admin]');

        $this->createManagers();

        $this->createAttendants();

        User::create([
            'company_id' => 1,
            'name' => 'Visitor',
            'email' => 'visitor@socialhub.pro', // $faker->safeEmail,
            'login' => 'visitor',
            'CPF' => '77777777777', // $faker->creditCardNumber,
            'role_id' => 4,
            'status_id' => 1,
            'password' => bcrypt('visitor'), // password
            'remember_token' => Str::random(10),
        ]);
        $this->command->info('Visitor created: [user: visitor@socialhub.pro, pass: visitor]');
    }

    public function createManagers()
    {
        User::create([
            'id' => 2,
            'company_id' => 1,
            'name' => 'Manager',
            'email' => 'manager@socialhub.pro',
            'login' => 'manager',
            'CPF' => '00000000001',
            'role_id' => 2,
            'status_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('manager'), // password
            'remember_token' => Str::random(10),
        ]);
        UsersManager::create([
            'user_id' => 2,
        ]);
        $this->command->info('Manager 1 created: [user: manager, pass: manager]');
    }

    public function createAttendants()
    {
        User::create([
            'id' => 3,
            'company_id' => 1,
            'name' => 'Attendant 1',
            'email' => 'attendant1@socialhub.pro',
            'login' => 'attendant1',
            'CPF' => '00000000002',
            'role_id' => 3,
            'status_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('attendant1'), // password
            'remember_token' => Str::random(10),
        ]);
        UsersAttendant::create([
            'user_id' => 3,
            'user_manager_id' => 2,
        ]);
        $this->command->info('Attendant 1 created: [user: attendant1, pass: attendant1]');
        User::create([
            'id' => 4,
            'company_id' => 1,
            'name' => 'Attendant 2',
            'email' => 'attendant2@socialhub.pro',
            'login' => 'attendant2',
            'CPF' => '00000000003',
            'role_id' => 3,
            'status_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('attendant2'), // password
            'remember_token' => Str::random(10),
        ]);
        UsersAttendant::create([
            'user_id' => 4,            
            'user_manager_id' => 2,
        ]);
        $this->command->info('Attendant 2 created: [user: attendant2, pass: attendant2]');
    }

}
