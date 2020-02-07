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
            'name' => 'ROUTED',
            'description' => 'Message sended from browser to server',
        ]);
        $this->command->info('Messages Status ROUTED');
        
        MessagesStatus::create([
            'id' => '2',
            'name' => 'SENDED',
            'description' => 'Message sended from server to Rasberry',
        ]);
        $this->command->info('Messages Status SENDED');
        MessagesStatus::create([
            'id' => '3',
            'name' => 'RECEVEIVED',
            'description' => 'Message was received by contact',
        ]);
        $this->command->info('Messages Status RECEVEIVED');
        MessagesStatus::create([
            'id' => '4',
            'name' => 'READED',
            'description' => 'Message was readed by contact',
        ]);
        $this->command->info('MessagesStatus READED');
        MessagesStatus::create([
            'id' => '5',
            'name' => 'DELETED',
            'description' => 'Message was deleted',
        ]);
        $this->command->info('MessagesStatus DELETED');

        MessagesStatus::create([
            'id' => '6',
            'name' => 'UNREADED',
            'description' => 'Message not readed by me, i.e., new incomming messages',
        ]);
        $this->command->info('MessagesStatus UNREADED');
    }

    function CreateContactsStatus() {
        $this->command->info('Creating Users ContactsStatus:');
        ContactsStatus::create([
            'id' => '1',
            'name' => 'ACTIVE',
            'description' => 'Contacts Status ACTIVE',
        ]);
        $this->command->info('ContactsStatus ACTIVE');
        
        ContactsStatus::create([
            'id' => '2',
            'name' => 'UNASSIGNED',
            'description' => 'Contact not assigned to attendant yet',
        ]);
        $this->command->info('Contacts Status UNASSIGNED');
        ContactsStatus::create([
            'id' => '3',
            'name' => 'PRIORITY',
            'description' => 'Contact have high priority',
        ]);
        $this->command->info('Contacts Status PRIORITY');
        
        ContactsStatus::create([
            'id' => '4',
            'name' => 'FOLLOWUP',
            'description' => 'Contact need to be folowup by attendant',
        ]);
        $this->command->info('Contacts Status FOLLOWUP');
        ContactsStatus::create([
            'id' => '5',
            'name' => 'ARCHIVED',
            'description' => 'Conversation wit this contact was classed and is archived. The contact will be not appear in the contact list',
        ]);
        $this->command->info('Contacts Status ARCHIVED');

        ContactsStatus::create([
            'id' => '6',
            'name' => 'SILENCED',
            'description' => 'Contact without Notifications',
        ]);
        $this->command->info('Contacts Status SILENCED');
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