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
            'json_data' => '{"urlProfilePicture":"https://pps.whatsapp.net/v/t61.24694-24/56106051_270963853793043_4343519337185804288_n.jpg?oe=5DC1B3BB&oh=fd9bd05b55714e5aa6b1ad892fb66903"}',
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
            'json_data' => '{"urlProfilePicture":"https://pps.whatsapp.net/v/t61.24694-24/56153764_2440222649335231_7717483608692228096_n.jpg?oe=5DC1B3BB&oh=47eaf313bce1feb6fa54a48a1fbdfa8c"}',
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
            'json_data' => '{"urlProfilePicture":"https://pps.whatsapp.net/v/t61.24694-24/69421822_488551565063752_860755220425080832_n.jpg?oe=5DC1B413&oh=ca39d010bbe344da5a12c3ebdb303438"}',
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
                'json_data' => '{"urlProfilePicture":"images/contacts/default.png"}',
                'status_id' => 1,
            ]);
            $this->command->info('Created authomatic contact name_'.$i);
        }
    }
}
