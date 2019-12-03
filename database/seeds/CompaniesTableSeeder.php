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
            'description' => 'Companie Social Hub',
        ]);
        $this->command->info('Companie Social Hub');

        
    }
}
