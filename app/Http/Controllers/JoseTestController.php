<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\ExtendedContactRepository;
use Illuminate\Support\Carbon;

use App\Models\AttendantsContact;

class JoseTestController extends Controller
{
    private $repository;

    

    public function __construct(ExtendedContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) {
        $contactsGrabriel = AttendantsContact::where('attendant_id', 102)->get();
    }
}
