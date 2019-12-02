<?php

namespace App\Repositories;

use App\Http\Controllers\MessagesStatusController;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;

class ExtendedChatRepository extends ChatRepository
{    

    public function contactChatAllAttendants(int $contact_id, int $page = null, string $searchMessageByStringInput = null): Collection{
        $ContactChats = new Collection();
        try {
            $extAttContRepo = new ExtendedContactRepository(app()); 

            $Attendants = $extAttContRepo->getAttendants($contact_id);

            foreach ($Attendants as $key => $Attendant) {
                $contactAttChats = $this->contactChat($Attendant->attendant_id, $contact_id);
                $ContactChats = $ContactChats->concat($contactAttChats);
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

        return $ContactChats;
    }

    public function getBagContact(int $attendant_id): Contact{
        try {
            $Contact = new Contact();

            $firstBagChat = $this->first();
    
            if ($firstBagChat) {
                $Chats = $this->findWhere(['contact_id' => $firstBagChat->contact_id])->all();
                // Move from Chats table to Attendant Table
                foreach ($Chats as $key => $Chat) {
                    $newChat = $Chat->replicate();
                    $newChat->table = (string)$attendant_id;
                    $newChat->attendant_id = $attendant_id;
                    $newChat->save();
        
                    $Chat->delete();
                }
        
                $Contact = Contact::find($firstBagChat->contact_id);
            }
            
            return $Contact;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function contactChat(int $attendant_id, int $contact_id, int $page = null, string $searchMessageByStringInput = null): Collection{
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;
        if (!$searchMessageByStringInput) {
            $firstBagChat = $chatModel->where('contact_id', $contact_id)->get();
            $chatModel->where('contact_id', $contact_id)
                      ->where('status_id', MessagesStatusController::UNREADED)
                      ->update(['status_id' => MessagesStatusController::READED]);
        } else {
            $firstBagChat = $chatModel->where('contact_id', $contact_id)->where('message', 'LIKE', '%'.$searchMessageByStringInput.'%')->get();//simplePaginate($page);
        }
        // $cities = $chatModel->model::whereHas('state', function($query) {
        //         $query->whereId($attendant_id);
        //     })
        //     ->pluck('name', 'id');
        return $firstBagChat;
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
