<?php

namespace App\Repositories;

use App\Http\Controllers\MessagesStatusController;
use App\Models\AttendantsContact;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExtendedChatRepository extends ChatRepository
{    

    public function contactChatAllAttendants(int $contact_id, int $page = null, string $searchMessageByStringInput = null): Collection{
        $ContactChats = new Collection();
        try {
            $extAttContRepo = new ExtendedContactRepository(app()); 

            $Attendants = $extAttContRepo->getAttendants($contact_id);

            foreach ($Attendants as $key => $Attendant) {
                $contactAttChats = $this->contactChat($Attendant->attendant_id, $contact_id, $page, $searchMessageByStringInput);
                $ContactChats = $ContactChats->concat($contactAttChats);
            }
            
        } catch (\Throwable $th) {
            throw $th;
        }

        return $ContactChats;
    }

    public function getBagContact(int $attendant_id): Contact{
        try {
            // First message from Bag
            $ChastMessages = $this->first();
            
            $Contact = null;
            if ($ChastMessages) {
                // Get Logged User
                $User = Auth::check() ? Auth::user() : session('logged_user');

                // Get contact From Bag by Contact Id
                // $Contact = Contact::find($ChastMessages->contact_id);
                // $Contact = new Contact();
                // $Contact->company_id = $User->company_id;
                // $Contact->whatsapp_id = $ChastMessages->contact_id;
                // $Contact->updated_at = time();
                // $Contact->save();

                // Associate contact to attendant $attendant_id
                $AttendantsContact = new AttendantsContact();
                $AttendantsContact->contact_id = $ChastMessages->contact_id;
                $AttendantsContact->attendant_id = $attendant_id;
                $AttendantsContact->save();
                
                // Move from Chats table to Attendant Table
                $Chats = $this->findWhere(['contact_id' => $ChastMessages->contact_id])->all();
                foreach ($Chats as $key => $Chat) {
                    $newChat = $Chat->replicate();
                    $newChat->table = (string)$attendant_id;
                    $newChat->attendant_id = $attendant_id;
                    $newChat->contact_id = $ChastMessages->contact_id;
                    $newChat->save();
        
                    $Chat->delete();
                }

                
                // Construct Contact with full data that chat need
                $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])->where(['id' => $ChastMessages->contact_id])->first();
                if ($Contact->latestAttendant && $Contact->latestAttendant->attendant_id == $attendant_id) {
                    // Get Contact Status
                    $Contact['latest_attendant'] = $Contact->latestAttendant->attendant()->first()->user()->first();
                    
                    // Last Chat Message
                        // Create chat model of $attendant_id to 
                        $chatModel = new $this->model();
                        $chatModel->table = (string) $attendant_id;
                    $lastMesssage = $chatModel->where('contact_id', $Contact->id)->latest('created_at')->get()->first();
                    $Contact['last_message'] = $lastMesssage;
                    
                    // Unreaded Messages Count
                    $countUnreadMessages = $chatModel
                        ->where('contact_id', $Contact->id)
                        ->where('status_id', 6) //UNREADED message for me
                        ->count();

                    $Contact['count_unread_messagess'] = $countUnreadMessages;
                }

            }
            
            return $Contact; //atrelar el last message igual que es atrelado en getContacts
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // 
    public function getBagContactsCount(): int{
        $count = $this->model()::select('contact_id')->distinct()->get();

        return $count->count();
    }

    public function contactChat(int $attendant_id, int $contact_id, int $page = null, string $searchMessageByStringInput = null): Collection{
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;
        
        if (!$searchMessageByStringInput) {
            $ChastMessages = $chatModel->where('contact_id', $contact_id)->get();
        } else {
            $ChastMessages = $chatModel->where('contact_id', $contact_id)->where('message', 'LIKE', '%'.$searchMessageByStringInput.'%')->get();//simplePaginate($page);
        }

        return $ChastMessages;
    }

    public function createMessage(array $attributes)
    {   
        $attendant_id = $attributes['attendant_id'];
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;

        //updating contact
        $contact_id = (int)$attributes['contact_id'];
        $Contact = Contact::find($contact_id);
        $Contact->updated_at = Carbon::now();
        $Contact->save();

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
