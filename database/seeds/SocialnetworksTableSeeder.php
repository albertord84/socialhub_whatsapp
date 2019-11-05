<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class SocialnetworksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->command->info('Truncate Socialnetworks Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('socialnetworks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Create Socialnetworks Roles:');
        Company::create([
            'id' => '1',
            'name' => 'WhatsApp',
            'description' => 'WhatsApp',
        ]);
        $this->command->info('Socialnetworks');
    }
}
