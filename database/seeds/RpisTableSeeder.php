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

    public function createRpis()
    {
        Rpi::create([
            'id' => 1,
            'company_id' => 1,

            'mac' => 'b8:27:eb:76:21:41',

            'api_tunnel' => 'http://shrpisocialhub.sa.ngrok.io.ngrok.io',
            'api_user' => 'socialhub',
            'api_password' => bcrypt('socialhub'),
            
            'ip' => '',
            'tcp_tunnel' => '1.tcp.ngrok.io',
            'tcp_port' => '29426',
            'root_user' => 'socialhub',
            'root_password' => '', //bcrypt('socialhub'),

            'soft_version' => '0.1.0',
            'soft_version_date' => '30/11/2019',
        ]);
        $this->command->info('RPi created: company 1 (Socialhub Bruno)');


        // Rpi::create([
        //     'id' => 2,
        //     'company_id' => 2,

        //     'mac' => 'b8:27:eb:1c:7f:d1',

        //     'api_tunnel' => 'http://shrpialberto.sa.ngrok.io.ngrok.io',
        //     'api_user' => 'socialhub',
        //     'api_password' => 'socialhub', // bcrypt('socialhub'),

        //     'ip' => '192.168.25.91',
        //     'tcp_tunnel' => '1.tcp.ngrok.io',
        //     'tcp_port' => '29426',
        //     'root_user' => 'socialhub',
        //     'root_password' => 'socialhub', // bcrypt('socialhub'),

        //     'soft_version' => '0.1.0',
        //     'soft_version_date' => '30/11/2019',
        // ]);
        // $this->command->info('RPi created: company 2 (Alberto Developing)');
        // Rpi::create([
        //     'id' => 3,
        //     'company_id' => 2,

        //     'mac' => 'b8:27:eb:3a:cb:bc',

        //     'api_tunnel' => 'http://shrpibruno.sa.ngrok.io.ngrok.io',
        //     'api_user' => 'socialhub',
        //     'api_password' => 'socialhub', // bcrypt('socialhub'),

        //     'ip' => '',
        //     'tcp_tunnel' => '1.tcp.ngrok.io',
        //     'tcp_port' => '29426',
        //     'root_user' => 'socialhub',
        //     'root_password' => 'socialhub', // bcrypt('socialhub'),

        //     'soft_version' => '0.1.0',
        //     'soft_version_date' => '30/11/2019',
        // ]);
        // $this->command->info('RPi created: company 2 (Alberto Developing)');
    }
}
