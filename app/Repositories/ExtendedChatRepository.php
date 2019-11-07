<?php

namespace App\Repositories;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;

class ExtendedChatRepository extends ChatRepository
{    

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

    public function createMessage(array $attributes)
    {   
        $attendant_id = $attributes['attendant_id'];
        $source = $attributes['source'];
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;
        return $chatModel->create($attributes);
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExtendedChat::class;
    }

}
