<?php

use App\Models\User;
use App\Models\UsersAttendant;
use App\Models\UsersManager;
use App\Repositories\ExtendedUsersAttendantRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->command->info('Truncate Users Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users_managers')->truncate();
        DB::table('users_attendants')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Creating Users:');

        // $faker = new Faker();
        $this->createAdmins(1);
        $this->createSellers(2);
        $this->createManagers(3);
        $this->createAttendants(4);
        $this->createVisitors(5);

        
    }

    public function createAdmins($role_id){
        User::create([
            'id' => 1,
            'company_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@socialhub.pro',
            'login' => 'admin',
            'role_id' => $role_id,
            'status_id' => 1,
            'password' => bcrypt('admin'),
        ]);
        $this->command->info('Admin created: [user: admin@socialhub.pro, pass: admin]');
    }

    public function createSellers($role_id){
        User::create([
            'id' => 2,
            'company_id' => 1,
            'name' => 'Seller 1',
            'email' => 'seller1@socialhub.pro',
            'login' => 'seller1',
            'CPF' => '00000000001',
            'role_id' => $role_id,
            'status_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('seller1'), // password
            'remember_token' => Str::random(10),
        ]);
        UsersManager::create([
            'user_id' => 2,
        ]);
        $this->command->info('Seller 1 created: [user: seller, pass: seller]');
    }
    
    public function createManagers($role_id){
        User::create([
            'id' => 3,
            'company_id' => 1,
            'name' => 'Manager',
            'email' => 'manager@socialhub.pro',
            'login' => 'manager',
            'CPF' => '00000000011',
            'role_id' => $role_id,
            'status_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('manager'), // password
            'remember_token' => Str::random(10),
        ]);
        UsersManager::create([
            'user_id' => 3,
        ]);
        $this->command->info('Manager 1 created: [user: manager, pass: manager]');
    }

    public function createAttendants($role_id){
        $attendantRepository = new ExtendedUsersAttendantRepository(app());
        User::create([
            'id' => 4,
            'company_id' => 1,
            'name' => 'Attendant 1',
            'email' => 'attendant1@socialhub.pro',
            'login' => 'attendant1',
            'CPF' => '00000000002',
            'role_id' => $role_id,
            'phone' => '(21)9659 13089',
            'status_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('attendant1'), // password
            'remember_token' => Str::random(10),
            'whatsapp_id' => '(21)965913089',
            'facebook_id' => 'facebook@attendant1',
            'instagram_id' => 'instagram@attendant1',
            'linkedin_id' => 'linkedin@attendant1',
        ]);
        UsersAttendant::create([
            'user_id' => 4,
            'user_manager_id' => 3,
        ]);
        $attendantRepository->createAttendantChatTable(4);
        $this->command->info('Attendant 1 created: [user: attendant1, pass: attendant1]');
        
        User::create([
            'id' => 5,
            'company_id' => 1,
            'name' => 'Attendant 2',
            'email' => 'attendant2@socialhub.pro',
            'login' => 'attendant2',
            'CPF' => '00000000003',
            'role_id' => $role_id,
            'status_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('attendant2'), // password
            'remember_token' => Str::random(10),
        ]);
        $attendantRepository->createAttendantChatTable(5);
        UsersAttendant::create([
            'user_id' => 5,            
            'user_manager_id' => 3,
        ]);
        $this->command->info('Attendant 2 created: [user: attendant2, pass: attendant2]');
    }

    public function createVisitors($role_id){
        User::create([
            'id' => 6,
            'company_id' => 1,
            'name' => 'Visitor',
            'email' => 'visitor@socialhub.pro', // $faker->safeEmail,
            'login' => 'visitor',
            'CPF' => '77777777777', // $faker->creditCardNumber,
            'role_id' => $role_id,
            'status_id' => 1,
            'password' => bcrypt('visitor'), // password
            'remember_token' => Str::random(10),
        ]);
        $this->command->info('Visitor created: [user: visitor@socialhub.pro, pass: visitor]');      
    }

    

}
