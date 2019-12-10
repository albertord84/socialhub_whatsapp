<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Companies Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('companies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Create Companies:');
        Company::create([
            'id' => '1',
            'name' => 'Social Hub',
            'phone' => '5511970111071@c.us',
            'rpi_id' => '1',
            'description' => 'Companie Social Hub',
        ]);
        Company::create([
            'id' => '2',
            'name' => 'Alberto Develop',
            'phone' => '5521965536174@c.us',
            'rpi_id' => '2',
            'description' => 'Companie Alberto Develop',
        ]);
        $this->command->info('Companie Alberto Develop');
        Company::create([
            'id' => '3',
            'name' => 'Social Hub Bruno',
            'phone' => '5511997239998@c.us',
            'rpi_id' => '2',
            'description' => 'Companie Social Hub Bruno',
        ]);
        $this->command->info('Companie Social Hub Bruno');

        
    }
}
