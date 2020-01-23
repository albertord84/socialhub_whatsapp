<?php

use App\Models\ExtendedChat;
use Illuminate\Database\Seeder;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\DB;

class ChatsTestsTableSeeder extends Seeder
{
    protected $schema;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->command->info('Truncate ChatsTests Tables...');
        DB::connection('socialhub_mvp.chats.test')->statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::connection('socialhub_mvp.chats.test')->table('chats')->truncate();
        DB::connection('socialhub_mvp.chats.test')->statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Generating 20 messages for Attendant 4 and Contact 1...');
        $this->createChatMessages(4, 2, 3);
        $this->command->info('Generating 30 messages for Attendant 4 and Contact 2...');
        $this->createChatMessages(4, 4, 3, 10);
        $this->command->info('Generating 100 messages for Attendant 5 and Contact 5...');
        $this->createChatMessages(5, 1, 3, 20);
        $this->command->info('Generating 100 messages for Attendant 5 and Contact 5...');
        $this->createChatMessages(5, 5, 3, 30);
        
    }
    
    public function createChatMessages(int $attendant_id, int $contact_id, int $amount, $start = 1) {
        
        $extendedChat = new ExtendedChat();    
        $extendedChat->connection = 'socialhub_mvp.chats.test';
        $extendedChat->table = 'chats';
        
        // text messages
        for($i=$start; $i<=$start+$amount; $i++){
            $extendedChat->create([
                'id' => $i,
                'contact_id' => $contact_id,
                'attendant_id' => $attendant_id,
                'source' => $i%2, //0->me  and 1->you
                'message' => Lorem::sentence(($i%9)+1, true),
                'type_id' => '1',
                'data' => '',
                'status_id' => '6',
                'socialnetwork_id' => '1',
            ]);
            $this->command->info('Message '.$i.' created');

        }

        //image file message
        $extendedChat->create([ 
            'id' => $i,
            'contact_id' => $contact_id,
            'attendant_id' => $attendant_id,
            'source' => $i%2, //0->me  and 1->you
            'message' => Lorem::sentence(($i%9)+1, true),
            'type_id' => '2',
            'data' => '{"ClientOriginalName":"image_test.jpg", "ClientOriginalExtension":"jpg","ClientMimeType":"jpg","guessClientExtension":"jpg","getSize":3136420,"isValid":true,"MaxFilesize":209715200,"SavedFileName":"image_test.jpg","SavedFilePath":""}',
            'status_id' => '6',
            'socialnetwork_id' => '1',
        ]);
        $this->command->info('Message '.$i.' created: Type image');
        
        //audio file message
        $i =$i + 1;
        $extendedChat->create([ 
            'id' => $i,
            'contact_id' => $contact_id,
            'attendant_id' => $attendant_id,
            'source' => $i%2, //0->me  and 1->you
            'message' => Lorem::sentence(($i%9)+1, true),
            'type_id' => '3',
            'data' => '{"ClientOriginalName":"audio_test.mp3", "ClientOriginalExtension":"mp3","ClientMimeType":"audio\/mp3","guessClientExtension":"mp3","getSize":3136420,"isValid":true,"MaxFilesize":209715200,"SavedFileName":"audio_test.mp3","SavedFilePath":""}',
            'status_id' => '6',
            'socialnetwork_id' => '1',
        ]);
        $this->command->info('Message '.$i.' created: Type audio');

        //video file message
        $i =$i + 1;
        $extendedChat->create([
            'id' => $i,
            'contact_id' => $contact_id,
            'attendant_id' => $attendant_id,
            'source' => $i%2, //0->me  and 1->you
            'message' => Lorem::sentence(($i%9)+1, true),
            'type_id' => '4',
            'data' => '{"ClientOriginalName":"video_test.mp4", "ClientOriginalExtension":"mp4","ClientMimeType":"video\/mp4","guessClientExtension":"mp4","getSize":3136420,"isValid":true,"MaxFilesize":209715200,"SavedFileName":"video_test.mp4","SavedFilePath":""}',
            'status_id' => '6',
            'socialnetwork_id' => '1',
        ]);
        $this->command->info('Message '.$i.' created: Type video');
        
        //document file message
        $i =$i + 1;
        $extendedChat->create([
            'id' => $i,
            'contact_id' => $contact_id,
            'attendant_id' => $attendant_id,
            'source' => $i%2, //0->me  and 1->you
            'message' => Lorem::sentence(($i%9)+1, true),
            'type_id' => '5',
            'data' => '{"ClientOriginalName":"document_test.pdf", "ClientOriginalExtension":"pdf","ClientMimeType":"text/pdf","guessClientExtension":"pdf","getSize":3136420,"isValid":true,"MaxFilesize":209715200,"SavedFileName":"document_test.pdf","SavedFilePath":""}',
            'status_id' => '6',
            'socialnetwork_id' => '1',
        ]);
        $this->command->info('Message '.$i.' created: Type video');
    }

    
}
