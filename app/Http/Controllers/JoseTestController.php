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

        $contacs_id = array( 55251, 55281, 55275, 55284, 55241, 55285, 55267, 55239, 55245, 55240, 55252, 55273, 55262, 55266, 55247, 55291, 55292, 55278, 55243, 55242, 55256, 55282, 55270, 55246, 55280, 55288, 55258, 55320, 55248, 55276, 55321, 55260, 55259, 55264, 55261, 55279, 55293, 55255, 55268, 55290, 55287, 55265, 55271, 55250, 55269, 55277, 55234, 55238, 55237, 55254, 55274, 55263, 55235, 55244, 55286, 55257, 55289, 55283, 55272, 55253, 55236, 55249)
    }
}
