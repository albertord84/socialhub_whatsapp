<?php

namespace App\Http\Controllers;

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


    // public function deleteAllByAttendantId(int $attendant_id)
    // {
    //     $this->attendantsContactRepository->deleteAllByAttendantId($attendant_id);
    // }

}
