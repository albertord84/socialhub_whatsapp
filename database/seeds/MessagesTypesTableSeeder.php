<?php

use App\Models\MessagesType;
use Illuminate\Database\Seeder;

class MessagesTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->command->info('Creating MessagesTypes:');
        $this->createMessagesTypes();
    }

    public function createMessagesTypes(){
        MessagesType::create([
            'id' => 1,
            'name' => 'Text',
            'description' => 'Text message type',
        ]);
        $this->command->info('Text message type created');
        
        MessagesType::create([
            'id' => 2,
            'name' => 'Image',
            'description' => 'Image message type',
        ]);
        $this->command->info('Image message type created');

        MessagesType::create([
            'id' => 3,
            'name' => 'Audio',
            'description' => 'Audio message type',
        ]);
        $this->command->info('Audio message type created');
        
        MessagesType::create([
            'id' => 4,
            'name' => 'Video',
            'description' => 'Video message type',
        ]);
        $this->command->info('Video message type created');

        MessagesType::create([
            'id' => 4,
            'name' => 'Documents',
            'description' => 'Documents message type',
        ]);
        $this->command->info('Documents message type created');



    }


}
