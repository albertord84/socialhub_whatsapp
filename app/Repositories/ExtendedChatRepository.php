<?php

namespace App\Repositories;
use App\Models\ExtendedChat;

class ExtendedChatRepository extends ChatRepository
{    
    //aqui vamos a tener que modificar la modelo tambien para coger la tabla chat del id del atendente

    public function contactChat(int $attendant_id, $contact_id, $page): Collection{
        $chatModel = new ExtendedChat();
        // $chatModel = new ExtendedChat($attendant_id);
        // $chatModel = $this->model();
        // $chatModel = new $this->model();
        // $chatModel->table = (string)$attendant_id;
        $Chat = $chatModel->model::get();
        dd($Chat);
        return $Chat;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExtendedChat::class;
    }

}
