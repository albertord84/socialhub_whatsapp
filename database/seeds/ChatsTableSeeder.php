<?php

use App\Models\ExtendedChat;
use Illuminate\Database\Seeder;
use Faker\Provider\Lorem;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // $this->command->info('Truncate Users Table...');
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('users_managers')->truncate();
        // DB::table('users_attendants')->truncate();
        // DB::table('users')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->createChatMessages(4,1,20);
        $this->createChatMessages(4,2,200);
        $this->createChatMessages(5,5,100);
        
    }
    
    public function createChatMessages(int $attendant_id, int $contact_id, int $amount) {
        $extendedChat = new ExtendedChat();    
        $extendedChat->table = (string)$attendant_id;
        for($i=1; $i<=$amount; $i++){
            $extendedChat->model::create([
                'id' => $i,
                'contact_id' => $attendant_id,
                'attendant_id' => $contact_id,
                'from' => (string)$i%2, //0->me  and 1->you
                'message' => Lorem::sentence($i%9,true),
                'type_id' => '1',
                'data' => '',
                'status_id' => '1',
                'socialnetwork_id' => '1',
            ]);
            $this->command->info('Message '.$i.' created');
        }
    }

    
}
