<?php

use App\Models\UsersStatus;
use App\Models\ContactsStatus;
use App\Models\MessagesStatus;
use Illuminate\Database\Seeder;
class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Truncate Status Tables (users, contacts, messages)...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users_status')->truncate();
        DB::table('contacts_status')->truncate();
        DB::table('messages_status')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->CreateUsersStatus();
        $this->CreateContactsStatus();
        $this->CreateMessagesStatus();
    }

    function CreateMessagesStatus() {
        $this->command->info('Creating Users MessagesStatus:');
        MessagesStatus::create([
            'id' => '1',
            'name' => 'ACTIVE',
            'description' => 'MessagesStatus ACTIVE',
        ]);
        $this->command->info('MessagesStatus ACTIVE');
    }

    function CreateContactsStatus() {
        $this->command->info('Creating Users ContactsStatus:');
        ContactsStatus::create([
            'id' => '1',
            'name' => 'ACTIVE',
            'description' => 'ContactsStatus ACTIVE',
        ]);
        $this->command->info('ContactsStatus ACTIVE');
        
        ContactsStatus::create([
            'id' => '2',
            'name' => 'UNASSIGNED',
            'description' => 'Contact not assigned to attendant yet',
        ]);
        $this->command->info('ContactsStatus ACTIVE');
    }

    function CreateUsersStatus() {
        $this->command->info('Creating Users UsersStatus:');
        UsersStatus::create([
            'id' => '1',
            'name' => 'ACTIVE',
            'description' => 'UsersStatus ACTIVE',
        ]);
        $this->command->info('UsersStatus ACTIVE');

        UsersStatus::create([
            'id' => '2',
            'name' => 'DELETED',
            'description' => 'UsersStatus DELETED',
        ]);
        $this->command->info('UsersStatus DELETED');

        UsersStatus::create([
            'id' => '3',
            'name' => 'INACTIVE',
            'description' => 'UsersStatus INACTIVE',
        ]);
        $this->command->info('UsersStatus INACTIVE');

        UsersStatus::create([
            'id' => '4',
            'name' => 'PENDING',
            'description' => 'UsersStatus PENDING',
        ]);
        $this->command->info('UsersStatus PENDING');

        UsersStatus::create([
            'id' => '5',
            'name' => 'BEGINNER',
            'description' => 'UsersStatus BEGINNER',
        ]);
        $this->command->info('UsersStatus BEGINNER');
        
        UsersStatus::create([
            'id' => '6',
            'name' => 'VERIFY_ACCOUNT',
            'description' => 'UsersStatus VERIFY_ACCOUNT',
        ]);
        $this->command->info('UsersStatus VERIFY_ACCOUNT');

        UsersStatus::create([
            'id' => '7',
            'name' => 'PAUSED',
            'description' => 'UsersStatus PAUSED',
        ]);
        $this->command->info('UsersStatus PAUSED');    
    }
}
