<?php

use App\Models\Rpi;
use Illuminate\Database\Seeder;

class RpisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate RPis Table...');
        DB::table('rpis')->truncate();

        $this->createRpis();
    }
    
    public function createRpis(){
        Rpi::create([
            'id' => 1,
            'company_id' => 1,            
            // 'mac' => 'string',
            'tunnel' => 'ngrok',
            'ip' => '192.168.25.91',
            'password' => bcrypt('ajmsocialhub'),
            'soft_version' => '0.0.1',
            'soft_version_date' => '30/11/2019',
        ]);
        $this->command->info('Admin created: [user: admin@socialhub.pro, pass: admin]');
    }
}
