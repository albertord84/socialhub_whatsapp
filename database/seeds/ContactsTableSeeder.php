<?php

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Contacts Table...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('contacts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Creating Contacts:');
        Contact::create([
            'id' => 1,
            'company_id' => 1,
            'first_name' => 'Alberto',
            'last_name' => 'Reyes',
            'email' => 'albertord84@gmail.com',
            'whatsapp_id' => '5521965536174',
            'status_id' => 1,
            'status_id' => 1,
        ]);
        $this->command->info('Contact Alberto Reyes');
        Contact::create([
            'id' => 2,
            'company_id' => 1,
            'first_name' => 'Jose',
            'last_name' => 'Ramon',
            'email' => 'josergm86@gmail.com',
            'whatsapp_id' => '5521965913089',
            'status_id' => 1,
        ]);
        $this->command->info('Contact Jose Ramon');
        Contact::create([
            'id' => 3,
            'company_id' => 1,
            'first_name' => 'Marcos',
            'last_name' => 'Medina',
            'email' => 'marcosmedina@azuregroup.com',
            'whatsapp_id' => '5511970111071',
            'status_id' => 1,
        ]);
        $this->command->info('Contact Marcos Medina');
        for( $i=4;$i<14;$i++){
            Contact::create([
                'id' => $i,
                'company_id' => 1,
                'first_name' => 'name_'.$i,
                'last_name' => 'surename_'.$i,
                'email' => 'authomatic_'.$i.'@gmail.com',
                'whatsapp_id' => '5511970111071_'.$i,
                'status_id' => 1,
            ]);
            $this->command->info('Created authomatic contact name_'.$i);
        }
    }
}
