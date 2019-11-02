<?php

namespace App\Repositories;
use App\Models\ExtendedChat;

class ExtendedChatRepository extends ChatRepository
{    
    //aqui vamos a tener que modificar la modelo tambien para coger la tabla chat del id del atendente
    
    public function model()
    {
        return ExtendedChat::class;
    }


    public function contactChat(int $attendant_id): Collection{
        $this->table = $attendant_id;
        $Chat = UsersAttendant::with('AttendantsContacts')->find($attendant_id);   /// NOOOOOOOO
	    $this->model()::with(...) //// THIS WAY

        // $Chat = UsersAttendant::with('AttendantsContacts')->find($attendant_id);
        // $Chat = new Collection();
        //     foreach ($Attentand['AttendantsContacts'] as $key => $AttendantsContact) {
        //         $AttendantsContactContact = $AttendantsContact->with('Contact')->find($AttendantsContact->id);
        //         $AttendantsContactContactStatus = $AttendantsContactContact['Contact']->with('Status')->find($AttendantsContactContact->contact_id);
        //         $Contacts[$key] = $AttendantsContactContactStatus;
        //     }
        return $Chat;
    }
}
