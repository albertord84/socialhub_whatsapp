<?php

namespace App\Repositories;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;

class ExtendedChatRepository extends ChatRepository
{    
    //aqui vamos a tener que modificar la modelo tambien para coger la tabla chat del id del atendente

    // public function contactChat(int $attendant_id, int $contact_id) {
    public function contactChat(int $attendant_id, int $contact_id): Collection{
        $chatModel = new $this->model();
        $chatModel->table = (string)$attendant_id;

        // Last Message
        // $lastMesssage = $chatModel->where('contact_id', $contact_id)->latest()->get();
        
        $Chat = $chatModel->where('contact_id', $contact_id)->get();

        // $cities = $chatModel->model::whereHas('state', function($query) {
        //         $query->whereId($attendant_id);
        //     })
        //     ->pluck('name', 'id');
        // return response()->json($cities);
        
        // $Chat = UsersAttendant::with('AttendantsContacts')->find($attendant_id);   /// NOOOOOOOO

        // $Chat = UsersAttendant::with('AttendantsContacts')->find($attendant_id);
        // $Chat = new Collection();
        // foreach ($Attentand['AttendantsContacts'] as $key => $AttendantsContact) {
        //     $AttendantsContactContact = $AttendantsContact->with('Contact')->find($AttendantsContact->id);
        //     $AttendantsContactContactStatus = $AttendantsContactContact['Contact']->with('Status')->find($AttendantsContactContact->contact_id);
        //     $Contacts[$key] = $AttendantsContactContactStatus;
        // }
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
