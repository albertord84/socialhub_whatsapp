<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\ExtendedContactRepository;
use Illuminate\Support\Carbon;

class JoseTestController extends Controller
{
    private $repository;

    

    public function __construct(ExtendedContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) {
        var_dump(Carbon::now()->diffInDays(Carbon::parse('2020-05-09 07:44')) );
    }
}
