<?php

namespace App\Repositories;

use App\Http\Controllers\MessagesStatusController;
use App\Models\AttendantsContact;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
use App\Models\Sales;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ExtendedChatRepository extends ChatRepository
{

    public function contactChatAllAttendants(int $contact_id, int $page = null, string $searchMessageByStringInput = null, $set_as_readed = 1): Collection
    {
        $ContactChats = new Collection();
        try {
            $extAttContRepo = new ExtendedContactRepository(app());

            $Attendants = $extAttContRepo->getAttendants($contact_id);

            foreach ($Attendants as $key => $Attendant) {
                $contactAttChats = $this->contactChat($Attendant->attendant_id, $contact_id, $page, $searchMessageByStringInput, $set_as_readed);

                $ContactChats = $ContactChats->concat($contactAttChats);
            }

            $ContactChats = $ContactChats->unique('id')->sortBy('created_at');
            // $ContactChats = $ContactChats->unique('id')->sortBy('updated_at');

            $Collection = new Collection();
            $page_length = env('APP_PAGE_LENGTH', 10);

            $msgCount = Count($ContactChats);
            $start = $msgCount - $page_length * $page - $page_length;
            if ($start < 0) { // Validating last page
                if ($start + $page_length <= 0) // if after last page return empty collection
                {
                    return $Collection;
                }

                // Needed in case the last page not to be a full page
                $page_length = $start + $page_length;
                $start = 0;
            }

            $Slice = $ContactChats->slice($start, $page_length)->all();
            foreach ($Slice as $key => $value) {
                $Collection->add($value);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        // return $ContactChats;
        return $Collection;
    }

    public function getBagContact(int $attendant_id): ?Contact
    {
        try {
            // First message from Bag
            $attendantUser = User::find($attendant_id);
            $ChastMessages = $this->model()::where('company_id', $attendantUser->company_id)->first();

            $Contact = null;

            if ($ChastMessages) {
                // Get Logged User
                $User = Auth::check() ? Auth::user() : session('logged_user');

                $Contact = Contact::with(['Status', 'latestAttendantContact', 'latestAttendant'])
                    ->where(['id' => $ChastMessages->contact_id])->first();

                // Get contact From Bag by Contact Id
                // $Contact = Contact::find($ChastMessages->contact_id);
                // $Contact = new Contact();
                // $Contact->company_id = $User->company_id;
                // $Contact->whatsapp_id = $ChastMessages->contact_id;
                // $Contact->updated_at = time();
                // $Contact->save();

                // Associate contact to attendant $attendant_id
                if ($Contact) {
                    $AttendantsContact = new AttendantsContact();
                    $AttendantsContact->contact_id = $ChastMessages->contact_id;
                    $AttendantsContact->attendant_id = $attendant_id;
                    $AttendantsContact->save();
                }

                $Company = Company::find($User->company_id);
                
                // Move from Sales table to Attendant Table
                if ($Company->bling_contrated) {
                    $Sales = new Sales();
                    $Sales->table = "$attendantUser->company_id";
                    $Sales = $Sales->where('contact_id', $ChastMessages->contact_id)->get();

                    foreach ($Sales as $key => $Sale) {
                        $newChat = new ExtendedChat();
                        $newChat->table = (string) $attendant_id;
                        $newChat->message = $Sale->message;
                        $newChat->attendant_id = $attendant_id;
                        $newChat->contact_id = $ChastMessages->contact_id;
                        $newChat->type_id = 1;
                        $newChat->status_id = $Sale->sended ? MessagesStatusController::SENDED : MessagesStatusController::ROUTED;
                        $newChat->source = 0;
                        $newChat->save();
                    }
                }

                // Move from Chats table to Attendant Table
                $Chats = $this->findWhere([
                    'company_id' => $attendantUser->company_id,
                    'contact_id' => $ChastMessages->contact_id,
                ])->all();
                foreach ($Chats as $key => $Chat) {
                    $newChat = $Chat->replicate();
                    $newChat->table = (string) $attendant_id;
                    $newChat->attendant_id = $attendant_id;
                    $newChat->contact_id = $ChastMessages->contact_id;
                    $newChat->save();

                    $Chat->delete();
                }

                // Construct Contact with full data that chat need
                if ($Contact && $Contact->latestAttendant && $Contact->latestAttendant->attendant_id == $attendant_id) {
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
                        ->where('status_id', MessagesStatusController::UNREADED) // UNREADED message for me
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
    public function getBagContactsCount(int $company_id): int
    {
        $count = $this->model()::where('company_id', $company_id)->select('contact_id')->distinct()->get();

        return $count->count();
    }

    public function contactChat(int $attendant_id, int $contact_id, int $page = null, string $searchMessageByStringInput = null, $set_as_readed = 1): Collection
    {
        $chatModel = new $this->model();
        $chatModel->table = isset($_SESSION['TESTING']) && $_SESSION['TESTING'] ? 'chats' : (string) $attendant_id;

        // Mark all messages read
        if ($set_as_readed) {
            $chatModel
                ->where('contact_id', $contact_id)
                ->where('status_id', MessagesStatusController::UNREADED)
                ->update(['status_id' => MessagesStatusController::READED]);
        }

        if (!$searchMessageByStringInput) {
            $ChastMessages = $chatModel->where('contact_id', $contact_id)->get();
        } else {
            $ChastMessages = $chatModel->where('contact_id', $contact_id)->where('message', 'LIKE', '%' . $searchMessageByStringInput . '%')->get(); //simplePaginate($page);
        }

        return $ChastMessages;
    }

    public function createMessage(array $attributes)
    {
        $attendant_id = $attributes['attendant_id'];
        $chatModel = new $this->model();
        $chatModel->table = (string) $attendant_id;

        //updating contact
        $contact_id = (int) $attributes['contact_id'];
        $Contact = Contact::find($contact_id);
        $Contact->updated_at = Carbon::now();
        $Contact->save();

        return $chatModel->create($attributes);
    }

    public function updateMessage(array $attributes, int $id)
    {
        $attendant_id = $attributes['attendant_id'];
        $chatModel = new $this->model();
        $chatModel->table = (string) $attendant_id;
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
