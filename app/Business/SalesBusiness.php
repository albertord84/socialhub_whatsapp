<?php

namespace App\Business;

use App\Models\Sales;
use App\Repositories\SalesRepository;
use Exception;
use stdClass;

class SalesBusiness extends Business {

    public function __construct()
    {
        parent::__construct();

        $this->repo = new SalesRepository(app());
    }    

    function createSale(stdClass $Sale)
    {
        dd($Sale);
        // 1. Crea la venta
        $SaleModel = Sales::blingConstruct($Sale);
        $SaleModel->save();
        // 2. Crea el contacto si no existe
        // 3. Envia un mensage
    }

}
