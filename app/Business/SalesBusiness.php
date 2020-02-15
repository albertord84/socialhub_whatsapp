<?php

namespace App\Business;

use App\Http\Controllers\ExternalRPIController;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Sales;
use App\Repositories\SalesRepository;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class SalesBusiness extends Business {

    public function __construct()
    {
        parent::__construct();

        $this->repo = new SalesRepository(app());
    }    

    function createSale(stdClass $Sale, Company $Company) : bool
    {
        try {
            // 1. Crea el contacto si no existe
            $hasClient = false;
            if (isset($Sale->pedido->cliente)) {
                $hasClient = true;
                $phone = ($Sale->pedido->cliente->celular != "")? $Sale->pedido->cliente->celular : $Sale->pedido->cliente->fone;
                $phone = trim($phone);
                if (!(strpos('55', $phone) === 0)) {
                    $phone = "55$phone";
                }

                // Check if the Contact already exist for this company
                $Contact = Contact::where([
                        'company_id' => $Company->id,
                        'whatsapp_id' => $phone,
                    ])->first();

                if (!$Contact) { // if not exist insert the contact
                    $Contact = new Contact();
                    $Contact->company_id = $Company->id;
                    $Contact->first_name = $Sale->pedido->cliente->nome;
                    $Contact->whatsapp_id = $phone;
                    $Contact->email = $Sale->pedido->cliente->email;
                    $Contact->save();
                }
            }
            else {
                $Contact->id = 0;
            }

            // 2. Crea la venta
            // Check if the Sale already exist for this company
            if (isset($Sale->pedido->numeroPedidoLoja)) {
                $SaleModel = new Sales;
                $SaleModel->table = "$Company->id";
                $SaleModel = $SaleModel->find($Sale->pedido->numeroPedidoLoja);
                if (!$SaleModel) { // if not exist insert the Sale
                    $SaleModel = Sales::blingConstruct($Sale, $Contact->id, $Company->id);
                    $SaleModel->save();


            // 3. Envia un mensage
                    $ExternalRPIController = new ExternalRPIController();
                    if ($hasClient)
                        $ExternalRPIController->sendTextMessage($Company->bling_message, $Contact);
                }
            }

        } catch (\Throwable $tr) {
            Log::debug('SalesBussines createSale', [$tr]);
            return false;
        }

        return true;
    }

}
