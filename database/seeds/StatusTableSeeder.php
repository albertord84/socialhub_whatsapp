<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Status Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('status')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Create Users Status:');
        Status::create([
            'id' => '1',
            'name' => 'ACTIVE',
            'description' => 'Status ACTIVE',
        ]);
        $this->command->info('Status ACTIVE');

        Status::create([
            'id' => '2',
            'name' => 'DELETED',
            'description' => 'Status DELETED',
        ]);
        $this->command->info('Status DELETED');

        Status::create([
            'id' => '3',
            'name' => 'INACTIVE',
            'description' => 'Status INACTIVE',
        ]);
        $this->command->info('Status INACTIVE');

        Status::create([
            'id' => '4',
            'name' => 'PENDING',
            'description' => 'Status PENDING',
        ]);
        $this->command->info('Status PENDING');

        Status::create([
            'id' => '5',
            'name' => 'BEGINNER',
            'description' => 'Status BEGINNER',
        ]);
        $this->command->info('Status BEGINNER');
        
        Status::create([
            'id' => '6',
            'name' => 'VERIFY_ACCOUNT',
            'description' => 'Status VERIFY_ACCOUNT',
        ]);
        $this->command->info('Status VERIFY_ACCOUNT');

        Status::create([
            'id' => '7',
            'name' => 'PAUSED',
            'description' => 'Status PAUSED',
        ]);
        $this->command->info('Status PAUSED');
    }
}
