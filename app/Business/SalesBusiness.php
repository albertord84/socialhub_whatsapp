<?php

namespace App\Business;

use App\Http\Controllers\BlingController;
use App\Http\Controllers\ContactsOriginsController;
use App\Http\Controllers\ExternalRPIController;
use App\Http\Controllers\MessagesStatusController;
use App\Http\Controllers\MessagesTypeController;
use App\Jobs\SendWhatsAppMsgBling;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ExtendedChat;
use App\Models\Sales;
use App\Repositories\SalesRepository;
use Illuminate\Database\Eloquent\Collection;
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
            $hasAttendant = false;
            if (isset($Sale->pedido->cliente)) {
                $hasClient = true;
                $phone = ($Sale->pedido->cliente->celular != "")? $Sale->pedido->cliente->celular : $Sale->pedido->cliente->fone;
                $phone = preg_replace("/[^0-9]/", "", $phone);
                if (($phone) && !(strpos('55', $phone) === 0)) {
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
                    $Contact->origin = ContactsOriginsController::BLING;
                    $Contact->save();
                }
                else if ($Contact->latestAttendantContact) {
                    $hasAttendant = true;
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
                    
                    
                    // $SaleModel->id = $SaleModel->id != 0 ? $SaleModel->id : $Sale->pedido->numero;
                    
                    // 3. Salvar un mensage
                    $Chat = null;
                    if ($hasClient && $phone) {
                        if ($hasAttendant) { // Save sale chat to attendant
                            $Chat = new ExtendedChat();
                            $Chat->contact_id = $Contact->id;
                            $Chat->company_id = $Company->id;
                            $Chat->type_id = MessagesTypeController::Text;
                            $Chat->status_id = MessagesStatusController::ROUTED;
                            $Chat->message = $SaleModel->message;
                            $Chat->attendant_id = $Contact->latestAttendantContact->attendant_id;
                            $Chat->source = 0;
                            $Chat->table = "$Chat->attendant_id";
                            $Chat->save();

                            $SaleModel->has_attendant = true;
                            $SaleModel->attendant_id = $Chat->attendant_id;
                            $SaleModel->chat_id = $Chat->id;
                            $SaleModel->status_id = $Chat->status_id;
                        
                        }
                        
                        $SaleModel->save();
                        // $objSale = (object) $SaleModel->toArray();
                        // $objChat = $Chat ? (object) $Chat->toArray() : null;
                        
                        // SendWhatsAppMsgBling::dispatch($ExternalRPIController, $Contact, $objChat, $objSale, 'blingsales');
                    }
                    
                    Log::error('Sales Bussines createSale', [$Contact->whatsapp_id]);
                }
            }
        } catch (\Throwable $tr) {
            Log::debug('SalesBussines createSale', [$tr]);
            return false;
        }
        
        return true;
    }
    
    public function createCompaniesJobs()
    {
        $Sales = new Collection();
        try {
            $Companies = Company::with('rpi')->where(['api_contrated' => true])->get();

            foreach ($Companies as $key => $Company) {
                $Sales = $this->getBlingCompanyNextObjects($Company);

                $ExternalRPIController = new ExternalRPIController($Company->rpi);

                // dd($Apis);

                foreach ($Sales as $key => $Sale) {
                    $this->createBlingJob($Sale, $ExternalRPIController);
                }
            }
        } catch (\Throwable $tr) {
            throw $tr;
        }

        return $Sales;
    }

    public function getBlingCompanyNextObjects(Company $Company): Collection
    {
        try {
            $SalesModel = new Sales();
            $SalesModel->table = "$Company->id";

            $Sales = $SalesModel->where('status_id', MessagesStatusController::ROUTED)->orderBy('updated_at', 'asc')->get()->take(env('APP_API_MESSAGES_X_MINUTE', 20));

            return $Sales;
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
    }

    public function createBlingJob(Sales $Sale, ExternalRPIController $ERPIC)
    {
        try {
            $Contact = Contact::find($Sale->contact_id);

            if ($Contact) {
                $Sale = (object) $Sale->toArray();

                SendWhatsAppMsgBling::dispatch($ERPIC, $Contact, $Sale, 'blingsales');
                // $apiJob = new SendWhatsAppMsgApi($ERPIC, $Contact, $Api);
                // $apiJob->handle();
            
            } else {
                throw new \Exception("createApiSendWhatsAppMsgApiJob Contact($Sale->contact_id) not found in Api ($Sale->id)");
            }

        } catch (\Throwable $tr) {
            Log::debug('ApiSendWhatsAppMsgApisBussines createApiSendWhatsAppMsgApi Job', [$tr]);
            return false;
        }

        return true;
    }    
    function builSaleMessage(stdClass $Sale, Company $Company) : string
    {
        // Log::debug('SalesBussines builSaleMessage', [$Sale]);

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

        $message = str_replace($search, "[dado não recebido]", $message);

        return $message;
    }

}
