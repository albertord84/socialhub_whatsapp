<?php

namespace App\Repositories;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;

class ExtendedChatRepository extends ChatRepository
{    
    //aqui vamos a tener que modificar la modelo tambien para coger la tabla chat del id del atendente

    // public function contactChat(int $attendant_id, int $contact_id) {
    public function contactChat(int $attendant_id, int $contact_id, int $page): Collection{
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;
        $Chat = $chatModel->where('contact_id', $contact_id)->get();
        // $cities = $chatModel->model::whereHas('state', function($query) {
        //         $query->whereId($attendant_id);
        //     })
        //     ->pluck('name', 'id');
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
