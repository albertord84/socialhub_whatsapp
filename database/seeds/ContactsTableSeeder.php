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
            'json_data' => '{"picurl":"images/contacts/alberto.jpg"}',
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
            'json_data' => '{"picurl":"images/contacts/jose_ramon.jpg"}',
            // 'json_data' => '{"picurl":"https://pps.whatsapp.net/v/t61.24694-24/56153764_2440222649335231_7717483608692228096_n.jpg?oe=5DC87488&oh=390fd24d73bdff889dd7e3242ef3422b"}',
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
            'json_data' => '{"picurl":"images/contacts/medina.jpg"}',
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
                'whatsapp_id' => '551197011107'.$i.'',
                'json_data' => '{"picurl":"images/contacts/default.png"}',
                'status_id' => 1,
            ]);
            $this->command->info('Created authomatic contact name_'.$i);
        }
    }
}
