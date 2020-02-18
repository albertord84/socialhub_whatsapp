<?php

use Illuminate\Database\Seeder;
use App\Models\Sales;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Sales Table...');
        DB::table('users_managers')->truncate();
        $this->command->info('Creating Sales:');
        $this->createSales();
    }

    public function createSales(){
        Sales::create([
            'id' => 1,
            'company_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@socialhub.pro',
            
        ]);
        $this->command->info('Admin created: [user: admin@socialhub.pro, pass: admin]');
    }


}
