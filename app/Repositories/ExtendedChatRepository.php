<?php

namespace App\Repositories;
use App\Models\ExtendedChat;

class ExtendedChatRepository extends ChatRepository
{    
    //aqui vamos a tener que modificar la modelo tambien para coger la tabla chat del id del atendente

    public function contactChat(int $attendant_id): Collection{
        $chatModel = $this->model();
        $chatModel->table = (string)$attendant_id;

        //$chatModel->model::with(...) //// THIS WAY
        
        // $Chat = UsersAttendant::with('AttendantsContacts')->find($attendant_id);   /// NOOOOOOOO

        // $Chat = UsersAttendant::with('AttendantsContacts')->find($attendant_id);
        // $Chat = new Collection();
        //     foreach ($Attentand['AttendantsContacts'] as $key => $AttendantsContact) {
        //         $AttendantsContactContact = $AttendantsContact->with('Contact')->find($AttendantsContact->id);
        //         $AttendantsContactContactStatus = $AttendantsContactContact['Contact']->with('Status')->find($AttendantsContactContact->contact_id);
        //         $Contacts[$key] = $AttendantsContactContactStatus;
        //     }
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
