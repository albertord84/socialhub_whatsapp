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
        $Collection = new Collection();
        if ($attendant_id) {
            $chatModel = new ExtendedChat();
            $chatModel->table = (string) $attendant_id;

            // $Attentand = UsersAttendant::with('AttendantsContacts')->find($attendant_id);
            // $Contacts = new Collection();
            // foreach ($Attentand['AttendantsContacts'] as $key => $AttendantsContact) {
            //     $AttendantsContactContact = $AttendantsContact->with('Contact')->find($AttendantsContact->id);
            //     $AttendantsContactContactStatus = $AttendantsContactContact['Contact']->with('Status')->find($AttendantsContactContact->contact_id);
            //     $lastMesssage = $chatModel->where('contact_id', $AttendantsContact->contact_id)->latest('created_at')->get()->first();
            //     $countUnreadMessages = $chatModel
            //         ->where('contact_id', $AttendantsContact->contact_id)
            //         ->where('status_id', 1)
            //         ->count();
            //     $Contacts[$key] = $AttendantsContactContactStatus;
            //     $Contacts[$key]['last_message'] = $lastMesssage;
            //     $Contacts[$key]['count_unread_messagess'] = $countUnreadMessages;
            // }
            $Contacts = $this->with(['Status', 'latestAttendantContact', 'latestAttendant'])->orderBy('updated_at', 'desc')->findWhere(['company_id' => $company_id]);
            foreach ($Contacts as $key => $Contact) {
                if ($Contact->latestAttendant && $Contact->latestAttendant->attendant_id == $attendant_id) {
                    // Get Contact Status
                    $Contacts[$key]['latest_attendant'] = $Contact->latestAttendant->attendant()->first()->user()->first();
                    
                    // Last Chat Message
                    $lastMesssage = $chatModel->where('contact_id', $Contact->id)->latest('created_at')->get()->first();
                    $Contacts[$key]['last_message'] = $lastMesssage;
                    
                    // Unreaded Messages Count
                    $countUnreadMessages = $chatModel
                    ->where('contact_id', $Contact->id)
                    ->where('status_id', 1)
                    ->count();
                    $Contacts[$key]['count_unread_messagess'] = $countUnreadMessages;

                    $Collection->add($Contacts[$key]);
                }
            }
            return $Collection;
        } else {
            // $Contacts = $this->with(['Status', 'latestAttendantContact', 'latestAttendant'])->findWhere(['company_id' => $company_id])->get();
            $Contacts = $this->with(['Status', 'latestAttendantContact', 'latestAttendant'])->findWhere(['company_id' => $company_id])->each(function ($Contact, $key) {
                if ($Contact->latestAttendant) {
                    $Contact->latestAttendant = $Contact->latestAttendant->attendant()->first()->user()->first();
                }
            });
            return $Contacts;
        }
    }

}
