<?php

namespace App\Repositories;

use App\Http\Controllers\MessagesStatusController;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;

class ExtendedChatRepository extends ChatRepository
{    

    public function contactChat(int $attendant_id, int $contact_id, int $page, string $searchMessageByStringInput): Collection{
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;
        if($searchMessageByStringInput ==''){
            $Chat = $chatModel->where('contact_id', $contact_id)->get();
            $chatModel->where('contact_id', $contact_id)
                      ->where('status_id', MessagesStatusController::UNREADED)
                      ->update(['status_id' => MessagesStatusController::READED]);
        }else{
            $Chat = $chatModel->where('contact_id', $contact_id)->where('message', 'LIKE', '%'.$searchMessageByStringInput.'%')->get();//simplePaginate($page);
        }
        // $cities = $chatModel->model::whereHas('state', function($query) {
        //         $query->whereId($attendant_id);
        //     })
        //     ->pluck('name', 'id');
        return $Chat;
    }

    public function createMessage(array $attributes)
    {   
        $attendant_id = $attributes['attendant_id'];
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;
        return $chatModel->create($attributes);
    }

    public function updateMessage(array $attributes, int $id)
    {   
        $attendant_id = $attributes['attendant_id'];
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;
        $chatModel->findOrFail($id);
        return $chatModel->save($attributes);
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExtendedChat::class;
    }

}
