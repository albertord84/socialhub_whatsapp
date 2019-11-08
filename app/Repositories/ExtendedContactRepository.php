<?php

namespace App\Repositories;

use App\Models\ExtendedChat;
use App\Models\UsersAttendant;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ExtendedContactRepository
 */
class ExtendedContactRepository extends ContactRepository
{

    public function fullContacts(int $company_id, ?int $attendant_id): Collection
    {
        if ($attendant_id) {
            $chatModel = new ExtendedChat();
            $chatModel->table = (string)$attendant_id;
            
            $Attentand = UsersAttendant::with('AttendantsContacts')->find($attendant_id);
            $Contacts = new Collection();
            foreach ($Attentand['AttendantsContacts'] as $key => $AttendantsContact) {
                $AttendantsContactContact = $AttendantsContact->with('Contact')->find($AttendantsContact->id);
                $AttendantsContactContactStatus = $AttendantsContactContact['Contact']->with('Status')->find($AttendantsContactContact->contact_id);
                $lastMesssage = $chatModel->where('contact_id', $AttendantsContact->contact_id)->latest('created_at')->get()->first();
                $countUnreadMessages = $chatModel
                    ->where('contact_id', $AttendantsContact->contact_id)
                    ->where('status_id', 1)
                    ->count();
                $Contacts[$key] = $AttendantsContactContactStatus;
                $Contacts[$key]['last_message'] = $lastMesssage;
                $Contacts[$key]['count_unread_messagess'] = $countUnreadMessages;
            }
        }
        else {
            $Contacts = $this->with(['Status', 'latestAttendantContact'])->findWhere(['company_id' => $company_id])->each(function ($Contact, $key) {
                $Attendant_User = null;
                if ($Contact['latestAttendantContact']) {
                    $latestAttendant = $Contact['latestAttendantContact']->with('Attendant')->find($Contact->id);
                    $Attendant_User = $latestAttendant['Attendant']->with('User')->find($latestAttendant->attendant_id);
                }
                $Contact->latestAttendant = $Attendant_User;
            });
        }
        return $Contacts;
    }

    

}
