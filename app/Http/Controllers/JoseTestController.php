<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\ExtendedContactRepository;

class JoseTestController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $repository
     * @return void
     */
    // public function __construct(ExtendedChatRepository $repository)
    public function __construct(ExtendedContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, stdClass $Sale, Company $Company)
    {
        $extContRepo = new ExtendedContactRepository(app());

        $Contacts = $extContRepo->fullContacts(1, $attendant_id, 'alb');

        dd($Contacts);
    }
}
