<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

use App\Repositories\ExtendedAttendantsContactRepository;

class ExtendedAttendantsContactController extends AttendantsContactController
{

    public function __construct(ExtendedAttendantsContactRepository $attendantsContactRepo)
    {
        parent::__construct($attendantsContactRepo);

        $this->attendantsContactRepository = $attendantsContactRepo;
    }

    public function deleteAllByContactId(int $contat_id)
    {
        $this->attendantsContactRepository->deleteAllByContactId($contat_id);
    }


    public function deleteAllByAttendantId(int $attendant_id, Request $request)
    {
        $this->attendantsContactRepository->deleteAllByAttendantId($attendant_id);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $attendantsContact = $this->attendantsContactRepository->create($input);

        Flash::success('Attendants Contact saved successfully.');

        $Contact = Contact::find($request->contact_id);
        $Contact->updated_at = time();
        $Contact->save();

        $attendantsContact->toJson();       


        // return redirect(route('attendantsContacts.index'));
    }

}
