<?php

use App\Models\ContactsOrigins;
use Illuminate\Database\Seeder;

class ContactsOriginsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Contacts Origins Table...');
        DB::table('contacts_origins')->truncate();

        $this->CreateContactsOrigins();
    }

    function CreateContactsOrigins() {
        $this->command->info('Creating Users MessagesStatus:');

        ContactsOrigins::create([
            'id' => '1',
            'name' => 'ORGANIC',
            'description' => 'Contact arrived from any marketing campaing',
        ]);
        $this->command->info('Contact Origin ORGANIC');
        
        ContactsOrigins::create([
            'id' => '2',
            'name' => 'MANUAL',
            'description' => 'Contact was added by a Manager or Attendant',
        ]);
        $this->command->info('Contact Origin MANUAL');

        ContactsOrigins::create([
            'id' => '3',
            'name' => 'CSV',
            'description' => 'Contact was added by a Manager from a CSV file',
        ]);
        $this->command->info('Contact Origin CSV');

        ContactsOrigins::create([
            'id' => '4',
            'name' => 'BLING',
            'description' => 'Contact arrived from Bling integration',
        ]);
        $this->command->info('Contact Origin BLING');

        ContactsOrigins::create([
            'id' => '5',
            'name' => 'CSV',
            'description' => 'Contact was added by a Manager from a CSV file',
        ]);
        $this->command->info('Contact Origin ORGANIC');


    }
}
