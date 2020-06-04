<?php

namespace App\Repositories;

use App\Http\Controllers\MessagesStatusController;
use App\Models\Contact;
use App\Models\ExtendedChat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

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

    public function fullContacts(int $company_id, ?int $attendant_id, string $filter = "", int $last_contact_idx = 0): Collection
    {
        $Collection = new Collection();
        if ($attendant_id) {
            $chatModel = new ExtendedChat();
            $chatModel->table = (string) $attendant_id;

            $last_contact_idx = $last_contact_idx >= 0 ? $last_contact_idx : 0;

            $Contacts = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
                ->whereHas('latestAttendantContact', function ($query) use ($attendant_id) {
                    $query->where('attendant_id', $attendant_id);
                })
                ->orderBy('updated_at', 'desc')
                ->where('company_id', $company_id);
                
            // Apply filters to contacts query
            if ($filter) $Contacts = $this->filterContacts($Contacts, $filter);

            $Contacts = $Contacts->get()->slice($last_contact_idx, env('APP_CONTACTS_PAGE_LENGTH', 30));

            foreach ($Contacts as $key => $Contact) {
                if ($Contact->latestAttendantContact->attendant_id == $attendant_id) {
                    // Get Contact Status
                    $Contacts[$key]['latest_attendant'] = $Contact->latestAttendant->attendant()->first()->user()->first();

                    // Last Chat Message
                    $lastMessage = $chatModel->where('contact_id', $Contact->id)->orderBy('id', 'desc')->get()->first();
                    // $lastMessage = $chatModel->where('contact_id', $Contact->id)->latest('created_at')->get()->first();
                    $Contacts[$key]['last_message'] = $lastMessage;

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
                ->where('company_id', $company_id);
            $Contacts = $this->filterContacts($Contacts, $filter);

            $Contacts = $Contacts
                ->skip($last_contact_idx)->take(env('APP_CONTACTS_PAGE_LENGTH_FOR_MANAGER', 30))->get()
                ->each(function ($Contact, $key) {
                    if ($Contact->latestAttendant) {
                        $Contact->latestAttendant = $Contact->latestAttendant->attendant()->first()->user()->first();
                    }
                });

            return $Contacts;
        }
    }
    
    public function fullContactsOfCompany(int $company_id)
    {
        $Contacts = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
        ->where('company_id', $company_id)
        ->get()
        ->each(function ($Contact, $key) {
            if ($Contact->latestAttendant) {
                $Contact->latestAttendant = $Contact->latestAttendant->attendant()->first()->user()->first();
            }
        });
        return $Contacts;
    }

    public function filterContacts(Builder $Contacts, string $filter) : Builder
    {
        $Contacts = $Contacts->where(function($query) use ($filter) {
            $query->where('contacts.first_name', 'LIKE', '%'.$filter.'%')
                ->orWhere('contacts.whatsapp_id', 'LIKE', '%'.$filter.'%')
                ->orWhere('contacts.email', 'LIKE', '%'.$filter.'%')
                ->orWhere('contacts.phone', 'LIKE', '%'.$filter.'%')
                ->orWhere('contacts.estado', 'LIKE', '%'.$filter.'%')
                ->orWhere('contacts.cidade', 'LIKE', '%'.$filter.'%')
                ->orWhere('contacts.categoria1', 'LIKE', '%'.$filter.'%')
                ->orWhere('contacts.categoria2', 'LIKE', '%'.$filter.'%');
        });

        return $Contacts;
    }

}
