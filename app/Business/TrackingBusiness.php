<?php

namespace App\Business;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Tracking;
use App\Models\Trackings;
use App\Repositories\TrackingRepository;
use Illuminate\Support\Facades\Log;
use stdClass;

class TrackingBusiness extends Business {

    public function __construct()
    {
        parent::__construct();

        $this->repo = new TrackingRepository(app());
    }    

    function createTrackingJob(Tracking $Tracking, Company $Company) : bool
    {
        try {
            // 1. Create tracking Job

        } catch (\Throwable $tr) {
            Log::debug('TrackingsBussines createTracking Job', [$tr]);
            return false;
        }

        return true;
    }

    function createTracking(stdClass $Tracking, Company $Company) : bool
    {
        try {
            // 1. Crea el contacto si no existe
            $hasClient = false;
            if (isset($Tracking->pedido->cliente)) {
                $hasClient = true;
                $phone = ($Tracking->pedido->cliente->celular != "")? $Tracking->pedido->cliente->celular : $Tracking->pedido->cliente->fone;
                $phone = preg_replace("/[^0-9]/", "", $phone);
                if (!(strpos('55', $phone) === 0) && ($phone != "")) {
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
                    $Contact->first_name = $Tracking->pedido->cliente->nome;
                    $Contact->whatsapp_id = $phone;
                    $Contact->email = $Tracking->pedido->cliente->email;
                    $Contact->save();
                }
            }
            else {
                $Contact->id = 0;
            }

            // 2. Crea la tracking
            // Check if the Tracking already exist for this company
            if (isset($Tracking->pedido->numero)) {
                $TrackingModel = new Trackings;
                $TrackingModel->table = "$Company->id";
                $TrackingModel = $TrackingModel->find($Tracking->pedido->numero);
                if (!$TrackingModel) { // if not exist insert the Tracking
                    $TrackingModel = Trackings::blingConstruct($Tracking, $Contact->id, $Company->id);

                    $TrackingModel->save();
                    Log::error('Trackings Bussines createTracking', [$Contact->whatsapp_id]);
                }
            }

        } catch (\Throwable $tr) {
            Log::debug('TrackingsBussines createTracking', [$tr]);
            return false;
        }

        return true;
    }

    function builTrackingMessage(stdClass $Tracking, Company $Company) : string
    {

        $replace = [
            $Tracking->pedido->desconto ?? '@desconto', 
            $Tracking->pedido->observacoes ?? '@pedido_observacoes', 
            $Tracking->pedido->data ?? '@pedido_data', 
            $Tracking->pedido->vendedor ?? '@pedido_vendedor', 
            $Tracking->pedido->valorfrete ?? '@pedido_valorfrete', 
            $Tracking->pedido->totalproduto ?? '@pedido_totalprodutos', 
            $Tracking->pedido->totalvenda ?? '@pedido_totalvenda',
            $Tracking->pedido->situacao ?? '@pedido_situacao', 
            $Tracking->pedido->dataPrevista ?? '@pedido_dataPrevista', 

            $Tracking->pedido->cliente->nome ?? '@cliente_nome', 
            $Tracking->pedido->cliente->cnpj ?? '@cliente_cnpj',
            $Tracking->pedido->cliente->cpf ?? '@cliente_cpf', 
            $Tracking->pedido->cliente->ie ?? '@cliente_ie', 
            $Tracking->pedido->cliente->rg ?? '@cliente_rg', 
            $Tracking->pedido->cliente->endereco ?? '@cliente_endereco',
            $Tracking->pedido->cliente->numero ?? '@cliente_numero', 
            $Tracking->pedido->cliente->complemento ?? '@cliente_complemento', 
            $Tracking->pedido->cliente->cidade ?? '@cliente_cidade', 
            $Tracking->pedido->cliente->bairro ?? '@cliente_bairro', 
            $Tracking->pedido->cliente->cep ?? '@cliente_cep', 
            $Tracking->pedido->cliente->email ?? '@cliente_email', 
            $Tracking->pedido->cliente->celular ?? '@cliente_celular',
            $Tracking->pedido->cliente->fone ?? '@cliente_fone', 

            $Tracking->pedido->itens[0]->item->codigo ?? '@item_codigo', 
            $Tracking->pedido->itens[0]->item->descricao ?? '@item_descricao', 
            $Tracking->pedido->itens[0]->item->quantidade ?? '@item_quantidade', 
            $Tracking->pedido->itens[0]->item->valorunidade ?? '@item_valorunidade', 
            $Tracking->pedido->itens[0]->item->precocusto ?? '@item_precocusto', 
            $Tracking->pedido->itens[0]->item->descontoItem ?? '@item_descontoItem', 
            $Tracking->pedido->itens[0]->item->un ?? '@item_un', 
            $Tracking->pedido->itens[0]->item->pesoBruto ?? '@item_pesoBruto', 
            $Tracking->pedido->itens[0]->item->largura ?? '@item_largura', 
            $Tracking->pedido->itens[0]->item->altura ?? '@item_altura', 
            $Tracking->pedido->itens[0]->item->profundidade ?? '@item_profundidade', 
            $Tracking->pedido->itens[0]->item->unidadeMedida ?? '@item_unidadeMedida', 
            $Tracking->pedido->itens[0]->item->descricaoDetalhada ?? '@item_descricaoDetalhada', 

            $Tracking->pedido->transporte->enderecoEntrega->nome ?? '@entrega_nome', 
            $Tracking->pedido->transporte->enderecoEntrega->endereco ?? '@entrega_endereco', 
            $Tracking->pedido->transporte->enderecoEntrega->numero ?? '@entrega_numero', 
            $Tracking->pedido->transporte->enderecoEntrega->complemento ?? '@entrega_complemento',
            $Tracking->pedido->transporte->enderecoEntrega->cidade ?? '@entrega_cidade', 
            $Tracking->pedido->transporte->enderecoEntrega->bairro ?? '@entrega_bairro', 
            $Tracking->pedido->transporte->enderecoEntrega->cep ?? '@entrega_cep', 
            $Tracking->pedido->transporte->enderecoEntrega->uf ?? '@entrega_uf'
        ];
        
        $search = [
            '@desconto', 
            '@pedido_observacoes', 
            '@pedido_data', 
            '@pedido_vendedor', 
            '@pedido_valorfrete', 
            '@pedido_totalprodutos', 
            '@pedido_totalvenda',
            '@pedido_situacao', 
            '@pedido_dataPrevista', 

            '@cliente_nome', 
            '@cliente_cnpj',
            '@cliente_cpf', 
            '@cliente_ie', 
            '@cliente_rg', 
            '@cliente_endereco',
            '@cliente_numero', 
            '@cliente_complemento', 
            '@cliente_cidade', 
            '@cliente_bairro', 
            '@cliente_cep', 
            '@cliente_email', 
            '@cliente_celular',
            '@cliente_fone', 

            '@item_codigo', 
            '@item_descricao', 
            '@item_quantidade', 
            '@item_valorunidade', 
            '@item_precocusto', 
            '@item_descontoItem', 
            '@item_un', 
            '@item_pesoBruto', 
            '@item_largura', 
            '@item_altura', 
            '@item_profundidade', 
            '@item_unidadeMedida', 
            '@item_descricaoDetalhada', 

            '@entrega_nome', 
            '@entrega_endereco', 
            '@entrega_numero', 
            '@entrega_complemento',
            '@entrega_cidade', 
            '@entrega_bairro', 
            '@entrega_cep', 
            '@entrega_uf'
        ];

        $message = str_replace($search, $replace, $Company->tracking_message);

        $message = str_replace($search, "não recebido", $Company->tracking_message);

        return $message;
    }

}
