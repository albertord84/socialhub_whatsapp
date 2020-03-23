<?php

namespace App\Repositories;

use App\Http\Controllers\MessagesStatusController;
use App\Models\Contact;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ExtendedContactRepository
 */
class ExtendedContactRepository extends ContactRepository
{

    /**
     * Get All Contact Attendants Last Firts
     *
     * @param integer $contact_id
     * @return Collection
     */
    public function getAttendants(int $contact_id): Collection
    {
        $Collection = new Collection();
        try {
            $Contact = $this->find($contact_id);
            $Attendants = $Contact->attendantsContacts()->orderBy('created_at', 'asc')->get();
            // $Attendants = $this->with(['attendantsContacts' => function($query) {
            //     $query->where('contact_id', 1);
            // }])->get();
            $Collection = $Attendants;
        } catch (\Throwable $th) {
            throw $th;
        }

        return $Collection;
    }

    public function fullContacts(int $company_id, ?int $attendant_id, ?array $filters, int $last_contact_idx = 0): Collection
    {
        $Collection = new Collection();
        if ($attendant_id) {
            $chatModel = new ExtendedChat();
            $chatModel->table = (string) $attendant_id;

            $Contacts = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
                ->whereHas('latestAttendantContact', function ($query) use ($attendant_id) {
                    $query->where('attendant_id', $attendant_id);
                })
                ->orderBy('updated_at', 'desc')
                ->where('company_id', $company_id)
                ->skip($last_contact_idx)->take(env('APP_CONTACTS_PAGE_LENGTH', 30))->get();

            foreach ($Contacts as $key => $Contact) {
                if ($Contact->latestAttendantContact->attendant_id == $attendant_id) {
                    // Get Contact Status
                    $Contacts[$key]['latest_attendant'] = $Contact->latestAttendant->attendant()->first()->user()->first();

                    // Last Chat Message
                    $lastMesssage = $chatModel->where('contact_id', $Contact->id)->latest('created_at')->get()->first();
                    $Contacts[$key]['last_message'] = $lastMesssage;

                    // Unreaded Messages Count
                    $countUnreadMessages = $chatModel
                        ->where('contact_id', $Contact->id)
                        ->where('status_id', MessagesStatusController::UNREADED) //UNREADED message for me
                        ->count();
                    $Contacts[$key]['count_unread_messagess'] = $countUnreadMessages;

                    $Collection->add($Contacts[$key]);
                }
            }

            return $Collection;
        } else {
            $Contacts = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
                ->where('company_id', $company_id)
                ->skip($last_contact_idx)->take(env('APP_CONTACTS_PAGE_LENGTH', 30))->get()
                ->each(function ($Contact, $key) {
                    if ($Contact->latestAttendant) {
                        $Contact->latestAttendant = $Contact->latestAttendant->attendant()->first()->user()->first();
                    }
                });

            return $Contacts;
        }
    }

}
