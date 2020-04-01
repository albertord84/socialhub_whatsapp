<?php

namespace App\Business;

use App\Http\Controllers\ExternalRPIController;
use App\Http\Controllers\MessagesStatusController;
use App\Http\Controllers\MessagesTypeController;
use App\Jobs\SendWhatsAppMsgBling;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
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
            if (isset($Sale->pedido->numero)) {
                $SaleModel = new Sales;
                $SaleModel->table = "$Company->id";
                $SaleModel = $SaleModel->find($Sale->pedido->numero);
                if (!$SaleModel) { // if not exist insert the Sale
                    $SaleModel = Sales::blingConstruct($Sale, $Contact->id, $Company->id);

                    $SaleModel->message = $this->builSaleMessage($Sale, $Company);
                    
                    // 3. Envia un mensage
                    $ExternalRPIController = new ExternalRPIController($Company->rpi);
                    if ($hasClient && $phone) {
                        // $checkContact = $ExternalRPIController->getContactInfo($Contact->whatsapp_id);
                        // $checkContact = json_decode($checkContact);
                        // if (is_object($checkContact) && isset($checkContact->name) && isset($checkContact->picurl)) {
                            // $response = $ExternalRPIController->sendTextMessage($SaleModel->message, $Contact);
                            $Chat = new ExtendedChat();
                            $Chat->contact_id = $Contact->id;
                            $Chat->company_id = $Company->id;
                            $Chat->type_id = MessagesTypeController::Text;
                            $Chat->status_id = MessagesStatusController::ROUTED;
                            $Chat->message = $SaleModel->message;
                            $Chat->save();

                            SendWhatsAppMsgBling::dispatch($ExternalRPIController, $Contact, $Chat, 'blingsales');
                            $SaleModel->sended = true;

                        // }
                        // else {
                        // }
                    }
                        
                    $SaleModel->save();
                    Log::error('Sales Bussines createSale', [$Contact->whatsapp_id]);
                }
            }

        } catch (\Throwable $tr) {
            Log::debug('SalesBussines createSale', [$tr]);
            return false;
        }

        return true;
    }

    function builSaleMessage(stdClass $Sale, Company $Company) : string
    {

        $replace = [
            $Sale->pedido->desconto ?? '@desconto', 
            $Sale->pedido->observacoes ?? '@pedido_observacoes', 
            $Sale->pedido->data ?? '@pedido_data', 
            $Sale->pedido->vendedor ?? '@pedido_vendedor', 
            $Sale->pedido->valorfrete ?? '@pedido_valorfrete', 
            $Sale->pedido->totalproduto ?? '@pedido_totalprodutos', 
            $Sale->pedido->totalvenda ?? '@pedido_totalvenda',
            $Sale->pedido->situacao ?? '@pedido_situacao', 
            $Sale->pedido->dataPrevista ?? '@pedido_dataPrevista', 

            $Sale->pedido->cliente->nome ?? '@cliente_nome', 
            $Sale->pedido->cliente->cnpj ?? '@cliente_cnpj',
            $Sale->pedido->cliente->cpf ?? '@cliente_cpf', 
            $Sale->pedido->cliente->ie ?? '@cliente_ie', 
            $Sale->pedido->cliente->rg ?? '@cliente_rg', 
            $Sale->pedido->cliente->endereco ?? '@cliente_endereco',
            $Sale->pedido->cliente->numero ?? '@cliente_numero', 
            $Sale->pedido->cliente->complemento ?? '@cliente_complemento', 
            $Sale->pedido->cliente->cidade ?? '@cliente_cidade', 
            $Sale->pedido->cliente->bairro ?? '@cliente_bairro', 
            $Sale->pedido->cliente->cep ?? '@cliente_cep', 
            $Sale->pedido->cliente->email ?? '@cliente_email', 
            $Sale->pedido->cliente->celular ?? '@cliente_celular',
            $Sale->pedido->cliente->fone ?? '@cliente_fone', 

            $Sale->pedido->itens[0]->item->codigo ?? '@item_codigo', 
            $Sale->pedido->itens[0]->item->descricao ?? '@item_descricao', 
            $Sale->pedido->itens[0]->item->quantidade ?? '@item_quantidade', 
            $Sale->pedido->itens[0]->item->valorunidade ?? '@item_valorunidade', 
            $Sale->pedido->itens[0]->item->precocusto ?? '@item_precocusto', 
            $Sale->pedido->itens[0]->item->descontoItem ?? '@item_descontoItem', 
            $Sale->pedido->itens[0]->item->un ?? '@item_un', 
            $Sale->pedido->itens[0]->item->pesoBruto ?? '@item_pesoBruto', 
            $Sale->pedido->itens[0]->item->largura ?? '@item_largura', 
            $Sale->pedido->itens[0]->item->altura ?? '@item_altura', 
            $Sale->pedido->itens[0]->item->profundidade ?? '@item_profundidade', 
            $Sale->pedido->itens[0]->item->unidadeMedida ?? '@item_unidadeMedida', 
            $Sale->pedido->itens[0]->item->descricaoDetalhada ?? '@item_descricaoDetalhada', 

            $Sale->pedido->transporte->enderecoEntrega->nome ?? '@entrega_nome', 
            $Sale->pedido->transporte->enderecoEntrega->endereco ?? '@entrega_endereco', 
            $Sale->pedido->transporte->enderecoEntrega->numero ?? '@entrega_numero', 
            $Sale->pedido->transporte->enderecoEntrega->complemento ?? '@entrega_complemento',
            $Sale->pedido->transporte->enderecoEntrega->cidade ?? '@entrega_cidade', 
            $Sale->pedido->transporte->enderecoEntrega->bairro ?? '@entrega_bairro', 
            $Sale->pedido->transporte->enderecoEntrega->cep ?? '@entrega_cep', 
            $Sale->pedido->transporte->enderecoEntrega->uf ?? '@entrega_uf'
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

        $message = str_replace($search, $replace, $Company->bling_message);

        return $message;
    }

}
