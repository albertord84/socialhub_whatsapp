<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Roles Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Create Users Roles:');
        Role::create([
            'id' => '1',
            'name' => 'ADMIN',
            'description' => 'Role Admin',
        ]);
        $this->command->info('Role ADMIN');
        Role::create([
            'id' => '2',
            'name' => 'MANAGER',
            'description' => 'Role MANAGER',
        ]);
        $this->command->info('Role MANAGER');
        Role::create([
            'id' => '3',
            'name' => 'ATTENDANT',
            'description' => 'Role ATTENDANT',
        ]);
        $this->command->info('Role ATTENDANT');
        Role::create([
            'id' => '4',
            'name' => 'VISITOR',
            'description' => 'Role VISITOR',
        ]);
        $this->command->info('Role VISITOR');
    }
}
