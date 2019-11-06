<?php

use App\Models\Socialnetwork;
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

        $this->command->info('Create Socialnetworks:');
        Socialnetwork::create([
            'id' => '1',
            'name' => 'WhatsApp'
        ]);
        $this->command->info('Created Socialnetworks');
    }
}
