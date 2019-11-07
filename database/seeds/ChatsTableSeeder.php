<?php

use App\Models\ExtendedChat;
use Illuminate\Database\Seeder;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\DB;

class ChatsTableSeeder extends Seeder
{
    protected $schema;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->command->info('Truncate Chats Tables...');
        DB::connection('socialhub_mvp.chats')->statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::connection('socialhub_mvp.chats')->table('4')->truncate();
        DB::connection('socialhub_mvp.chats')->table('5')->truncate();
        DB::connection('socialhub_mvp.chats')->statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Generating 20 messages for Attendant 4 and Contact 1...');
        $this->createChatMessages(4, 1, 20);
        $this->command->info('Generating 30 messages for Attendant 4 and Contact 2...');
        $this->createChatMessages(4, 2, 30, 22);
        $this->command->info('Generating 100 messages for Attendant 5 and Contact 5...');
        $this->createChatMessages(5, 5, 100);
        
    }
    
    public function createChatMessages(int $attendant_id, int $contact_id, int $amount, $start = 1) {
        $extendedChat = new ExtendedChat();    
        $extendedChat->table = (string)$attendant_id;
        for($i=$start; $i<=$start+$amount; $i++){
            $extendedChat->create([
                'id' => $i,
                'contact_id' => $contact_id,
                'attendant_id' => $attendant_id,
                'source' => $i%2, //0->me  and 1->you
                'message' => Lorem::sentence(($i%9)+1, true),
                'type_id' => '1',
                'data' => '',
                'status_id' => '1',
                'socialnetwork_id' => '1',
            ]);
            $this->command->info('Message '.$i.' created');
        }
    }

    
}
