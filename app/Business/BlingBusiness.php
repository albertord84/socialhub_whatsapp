<?php

namespace App\Business;

use App\Models\Company;
use App\Repositories\BlingRepository;
use Illuminate\Database\Eloquent\Collection;

class BlingBusiness extends Business {

    public function __construct()
    {
        parent::__construct();

        $this->repo = new BlingRepository(app());
    }    

    public function getBlingSales() : Collection
    {
        $Sales = new Collection();
        try {
            $Companies = Company::where(['bling_contrated' => true])->get();
            dd($Companies);
        } catch (\Throwable $tr) {
            // throw $tr;
        }

        $Sales;
    }

}
