<?php

namespace App\Business;

use App\Http\Controllers\StatusController;
use App\Http\Controllers\TrackingController;
use App\Models\Company;
use App\Models\Tracking;
use App\Repositories\TrackingRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostofficeBusiness extends Business
{

    public function __construct()
    {
        parent::__construct();

        $this->repo = new TrackingRepository(app());
    }

    public function getCompanies(): Collection
    {
        $Objects = new Collection();
        try {
            $Companies = Company::with('rpi')->where(['tracking_contrated' => true])->get();

            return $Companies;
        } catch (\Throwable $tr) {
            throw $tr;
        }

        return $Objects;
    }

    public function createCompaniesJobs()
    {
        $Objects = new Collection();
        try {
            $Companies = Company::with('rpi')->where(['tracking_contrated' => true])->get();

            // dd($Companies);

            $trackingBussines = new TrackingBusiness();
            foreach ($Companies as $key => $Company) {
                $Objects = $this->getTrackingCompanyNextObjects($Company);

                // dd($Objects);

                foreach ($Objects as $key => $Object) {
                    $updated_at = new Carbon($Object->updated_at);
                    if ($updated_at->diffInDays() >= 1) { // Verify whether not checked today
                        $trackingBussines->createTrackingJob($Object, $Company);
                    }
                }
            }
        } catch (\Throwable $tr) {
            throw $tr;
        }

        return $Objects;
    }

    public function getTrackingCompanyNextObjects(Company $Company): Collection
    {
        try {
            $TrackingModel = new Tracking();
            $TrackingModel->table = "$Company->id";

            $Objects = $TrackingModel->where('status_id', '!=', TrackingController::TRACKING_RECEIVED)->orderBy('updated_at', 'asc')->get()->slice(0, env('APP_TRACKING_MESSAGES_X_MINUTE', 10));

            return $Objects;
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
    }

    public function importCSV(UploadedFile $file, DateTime $date = null): array
    {
        // $file = $file ?? Storage::disk('chats_files_1')->get('storage/Pedidos.csv');
        // $objCodeCol = 'envioRastreamento';
        try {
            $User = Auth::check() ? Auth::user() : session('logged_user');

            $Company = Company::find($User->company_id);

            // if (File::isFile($file)) {
            // Convert the file content to a Objects array
            // $Trackings = $this->csv_to_array('/var/www/html/app.socialhub.local/public/storage/Pedidos.csv', ';');
            $Trackings = $this->csv_to_array($file->getRealPath());

            // dd($Trackings);
            
            $response = array(
                'criated' => 0,
                'already_exist' => 0,
                'exception' => 0
            );

            foreach ($Trackings as $key => $Objects) {
                $trackingBussines = new TrackingBusiness();
                $result = $trackingBussines->createTracking($Objects, $Company);

                if($result === 'criated') $response['criated']++; 
                else if($result === 'already_exist') $response['already_exist']++; 
                else if($result === 'exception') $response['exception']++;
            }

            return $response;
        } catch (\Throwable $th) {
            // return MyResponse::makeExceptionJson($th);
            throw $th;
        }

        return null;
    }

    public function csv_to_array($filename = '', $delimiter = ';'): ?array
    {
        try {
            if (!file_exists($filename) || !is_readable($filename)) {
                return null;
            }

            $header = array();
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false) {
                $header = fgetcsv($handle, 0, $delimiter);
                // while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE)
                while (($row = fgets($handle)) !== false) {
                    $row = html_entity_decode($row);
                    $row = explode($delimiter, $row);

                    if (count($row) == count($header)) {
                        $data[] = json_decode(json_encode(array_combine($header, $row)));
                    }
                }
                fclose($handle);
            }
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
        return $data;
    }

    public function trackingImportantEventListSended() : array
    {
        $Events = [
            ['DO',	'1'],	'Objeto encaminhado',
            ['DO',	'2'],	'Objeto encaminhado',
            ['RO',	'1'],	'Objeto encaminhado'
        ];
        return $Events;
    }

    public function trackingImportantEventList() : array
    {
        $Events = [
            ['BDE', '4'], 'Cliente recusou-se a receber o objeto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDE', '5'], 'A entrega não pode ser efetuada	Objeto será devolvido ao remetente',
            ['BDE', '6'], 'Cliente desconhecido no local - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDE', '7'], 'Endereço incorreto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDE', '8'], 'Endereço incorreto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDI', '4'], 'Cliente recusou-se a receber o objeto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDI', '5'], 'A entrega não pode ser efetuada	Objeto será devolvido ao remetente',
            ['BDI', '6'], 'Cliente desconhecido no local - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDI', '7'], 'Endereço incorreto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDI', '8'], 'Endereço incorreto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDR', '7'], 'Endereço incorreto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDR', '8'], 'Endereço incorreto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDR', '4'], 'Cliente recusou-se a receber o objeto - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDR', '5'], 'A entrega não pode ser efetuada	Objeto será devolvido ao remetente',
            ['BDR', '6'], 'Cliente desconhecido no local - Entrega não realizada	Objeto será devolvido ao remetente',
            ['FC',  '4'], 'Endereço incorreto - Entrega não realizada	Objeto sujeito a atraso na entrega ou a devolução ao remetente',
            ['BDE', '2'], 'Carteiro não atendido - Entrega não realizada	Aguarde: objeto estará disponível para retirada na unidade a ser informada',
            ['LDI', '1'], 'Objeto aguardando retirada no endereço indicado	Para retirá-lo, é preciso informar o código do objeto e apresentar documentação que comprove ser o destinatário ou pessoa por ele oficialmente autorizada.',
            ['LDI', '3'], 'Objeto aguardando retirada no endereço indicado	Para retirá-lo, é preciso informar o código do objeto e apresentar documentação que comprove ser o destinatário ou pessoa por ele oficialmente autorizada.',
            ['LDI', '4'], 'Objeto aguardando retirada no endereço indicado	Para retirá-lo, é preciso informar o código do objeto e apresentar documentação que comprove ser o destinatário ou pessoa por ele oficialmente autorizada.',
            ['BDI', '2'], 'Carteiro não atendido - Entrega não realizada	Aguarde: objeto estará disponível para retirada na unidade a ser informada',
            ['BDR', '2'], 'Carteiro não atendido - Entrega não realizada	Aguarde: objeto estará disponível para retirada na unidade a ser informada',
            ['BDE', '3'], 'Remetente não retirou objeto na Unidade dos Correios	Objeto em análise de destinação',
            ['BDI', '3'], 'Remetente não retirou objeto na Unidade dos Correios	Objeto em análise de destinação',
            ['BDI', '9'], 'Objeto ainda não chegou à unidade	Por favor, aguarde',
            ['BDR', '3'], 'Remetente não retirou objeto na Unidade dos Correios	Objeto em análise de destinação',
            ['FC',  '3'], 'Objeto mal encaminhado	Encaminhamento a ser corrigido',
            ['BDE', '9'], 'Objeto ainda não chegou à unidade	Por favor, aguarde',
            ['FC',  '8'], 'Área com distribuição sujeita a prazo diferenciado	Restrição de entrega domiciliar temporária',
            ['BDR', '9'], 'Objeto ainda não chegou à unidade	Por favor, aguarde',
            ['BDE', '10'], 'Cliente mudou-se - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDE', '21'], 'Carteiro não atendido - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDE', '26'], 'Destinatário não retirou objeto no prazo	Objeto será devolvido ao remetente',
            ['BDE', '36'], 'Coleta ou entrega de objeto não efetuada	Objeto será devolvido ao remetente',
            ['BDE', '48'], 'Retirada em Unidade dos Correios não autorizada pelo remetente	Objeto será devolvido ao remetente',
            ['BDE', '49'], 'As dimensões do objeto impossibilitam o tratamento e a entrega	O objeto será devolvido ao remetente',
            ['BDE', '89'], 'Localidade desconhecida no Brasil	Objeto será devolvido ao remetente',
            ['BDI', '10'], 'Cliente mudou-se - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDI', '21'], 'Carteiro não atendido - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDI', '26'], 'Destinatário não retirou objeto no prazo	Objeto será devolvido ao remetente',
            ['BDI', '36'], 'Coleta ou entrega de objeto não efetuada	Objeto será devolvido ao remetente',
            ['BDI', '48'], 'Retirada em Unidade dos Correios não autorizada pelo remetente	Objeto será devolvido ao remetente',
            ['BDI', '49'], 'As dimensões do objeto impossibilitam o tratamento e a entrega	O objeto será devolvido ao remetente',
            ['BDI', '89'], 'Localidade desconhecida no Brasil	O objeto será devolvido ao remetente',
            ['BDR', '10'], 'Cliente mudou-se - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDR', '21'], 'Carteiro não atendido - Entrega não realizada	Objeto será devolvido ao remetente',
            ['BDR', '26'], 'Destinatário não retirou objeto no prazo	Objeto será devolvido ao remetente',
            ['BDR', '36'], 'Coleta ou entrega de objeto não efetuada	Objeto será devolvido ao remetente',
            ['BDR', '48'], 'Retirada em Unidade dos Correios não autorizada pelo remetente	Objeto será devolvido ao remetente',
            ['BDR', '49'], 'As dimensões do objeto impossibilitam o tratamento e a entrega	O objeto será devolvido ao remetente',
            ['BDR', '64'], 'Solicitação de dados não atendida	O objeto será devolvido ao remetente',
            ['BDR', '89'], 'Localidade desconhecida no Brasil	Objeto será devolvido ao remetente',
            ['BDE', '19'], 'Endereço incorreto - Entrega não realizada	Objeto sujeito a atraso na entrega ou a devolução ao remetente',
            ['BDE', '34'], 'A entrega não pode ser efetuada - Logradouro com numeração irregular	Objeto sujeito a atraso na entrega ou a devolução ao remetente',
            ['BDI', '19'], 'Endereço incorreto - Entrega não realizada	Objeto sujeito a atraso na entrega ou a devolução ao remetente',
            ['BDI', '34'], 'A entrega não pode ser efetuada - Logradouro com numeração irregular	Objeto sujeito a atraso na entrega ou a devolução ao remetente',
            ['BDR', '19'], 'Endereço incorreto - Entrega não realizada	Objeto sujeito a atraso na entrega ou a devolução ao remetente',
            ['BDR', '34'], 'A entrega não pode ser efetuada - Logradouro com numeração irregular	Objeto sujeito a atraso na entrega ou a devolução ao remetente',
            ['BDE', '42'], 'Lote de objetos incompleto	Em devolução ao remetente',
            ['BDI', '42'], 'Lote de objetos incompleto	Em devolução ao remetente',
            ['BDR', '42'], 'Lote de objetos incompleto	Em devolução ao remetente',
            ['FC',  '41'], 'Problemas na documentação do objeto	Procure a agência de postagem em até 2 dias úteis',
            ['PAR', '40'], 'Devolução a pedido	Cliente solicitou a devolução da encomenda',
            ['BDE', '18'], 'Carteiro não atendido - Entrega não realizada	Será realizada nova tentativa de entrega no sábado',
            ['BDE', '20'], 'Carteiro não atendido - Entrega não realizada	Será realizada nova tentativa de entrega',
            ['BDI', '18'], 'Carteiro não atendido - Entrega não realizada	Será realizada nova tentativa de entrega no sábado',
            ['BDI', '20'], 'Carteiro não atendido - Entrega não realizada	Será realizada nova tentativa de entrega',
            ['BDR', '18'], 'Carteiro não atendido - Entrega não realizada	Será realizada nova tentativa de entrega no sábado',
            ['BDR', '20'], 'Carteiro não atendido - Entrega não realizada	Será realizada nova tentativa de entrega',
            ['BDE', '12'], 'Remetente não retirou objeto na Unidade dos Correios	Objeto em análise de destinação',
            ['BDE', '13'], 'Objeto atingido por incêndio em unidade operacional	',
            ['BDE', '14'], 'Desistência de postagem pelo remetente	',
            ['BDE', '22'], 'Objeto devolvido aos Correios	',
            ['BDE', '25'], 'Empresa sem expediente - Entrega não realizada	Entrega deverá ocorrer no próximo dia útil',
            ['BDE', '28'], 'Objeto e/ou conteúdo avariado	',
            ['BDE', '29'], 'Objeto não localizado	',
            ['BDE', '33'], 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido	',
            ['BDE', '37'], 'Objeto e/ou conteúdo avariado por acidente com veículo	',
            ['BDE', '38'], 'Objeto endereçado à empresa falida	Objeto será encaminhado para entrega ao administrador judicial',
            ['BDE', '39'], 'A entrega não pode ser efetuada	Objeto em análise de destinação',
            ['BDE', '40'], 'Não foi autorizada a entrada do objeto no país pelos órgãos fiscalizadores	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDE', '43'], 'Objeto apreendido por órgão de fiscalização	Objeto está em poder da autoridade competente',
            ['BDE', '44'], 'Aguardando órgão anuente apresentar documentação fiscal	',
            ['BDE', '50'], 'Objeto roubado	',
            ['BDE', '51'], 'Objeto roubado	',
            ['BDE', '52'], 'Objeto roubado	',
            ['BDE', '54'], 'Aguardando a guia de recolhimento para pagamento do ICMS Importação	Por favor, aguarde.',
            ['BDE', '55'], 'Solicitação de revisão do tributo	Acesse Minhas Importações para acompanhamento do pedido de revisão',
            ['BDE', '56'], 'Objeto com declaração aduaneira ausente ou incorreta	Aguarde: objeto em tratamento e sujeito a devolução',
            ['BDE', '60'], 'Objeto encontra-se aguardando prazo para refugo	',
            ['BDE', '61'], 'Objeto refugado	Devolução proibida por órgão anuente ou não contratada pelo remetente',
            ['BDE', '62'], 'Em devolução à origem por determinação da Receita Federal	Objeto poderá ser devolvido à origem ou encaminhado para refugo de acordo com orientação do remetente',
            ['BDE', '71'], 'Objeto apreendido por: ANVISA/VIGILANCIA SANITARIA	O objeto está em poder da autoridade competente',
            ['BDE', '72'], 'Objeto apreendido por: BOMBEIROS	O objeto está em poder da autoridade competente',
            ['BDE', '73'], 'Objeto apreendido por: EXERCITO	O objeto está em poder da autoridade competente',
            ['BDE', '74'], 'Objeto apreendido por: IBAMA	O objeto está em poder da autoridade competente',
            ['BDE', '75'], 'Objeto apreendido por: POLICIA FEDERAL	O objeto está em poder da autoridade competente',
            ['BDE', '76'], 'Objeto apreendido por: POLICIA CIVIL/MILITAR	O objeto está em poder da autoridade competente',
            ['BDE', '77'], 'Evento RFB - Aguardando DTRAT	',
            ['BDE', '79'], 'POSTAGEM INEXISTENTE (RESERVADO DERAT)	',
            ['BDE', '80'], 'Objeto não localizado no fluxo postal	',
            ['BDE', '81'], 'Não foi autorizada a saída do objeto do país pelos órgãos fiscalizadores	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDE', '82'], 'Necessário complementar endereço de entrega	Acesse o Fale Conosco > Reclamação > Objeto em processo de desembaraço',
            ['BDE', '83'], 'Ação necessária à liberação do objeto não realizada pelo cliente	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDE', '84'], 'Verificando situação do objeto	Por favor, aguarde',
            ['BDE', '85'], 'Código do objeto fora do padrão	Objeto será entregue sem rastreamento',
            ['BDE', '86'], 'Objeto com conteúdo avariado	Sem condições de entrega',
            ['BDE', '87'], 'Objeto destinado a outro país	',
            ['BDE', '98'], 'Objeto não localizado no fluxo postal	',
            ['BDI', '12'], 'Remetente não retirou objeto na Unidade dos Correios	Objeto em análise de destinação',
            ['BDI', '13'], 'Objeto atingido por incêndio em unidade operacional	',
            ['BDI', '14'], 'Desistência de postagem pelo remetente	',
            ['BDI', '25'], 'Empresa sem expediente - Entrega não realizada	Entrega deverá ocorrer no próximo dia útil',
            ['BDI', '28'], 'Objeto e/ou conteúdo avariado	',
            ['BDI', '29'], 'Objeto não localizado	',
            ['BDI', '30'], 'Saída não efetuada	Em tratamento, aguarde.',
            ['BDI', '33'], 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido	',
            ['BDI', '37'], 'Objeto e/ou conteúdo avariado por acidente com veículo	',
            ['BDI', '38'], 'Objeto endereçado à empresa falida	Objeto será encaminhado para entrega ao administrador judicial',
            ['BDI', '39'], 'A entrega não pode ser efetuada	Objeto em análise de destinação',
            ['BDI', '40'], 'Não foi autorizada a entrada do objeto no país pelos órgãos fiscalizadores	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDI', '43'], 'Objeto apreendido por órgão de fiscalização	Objeto está em poder da autoridade competente',
            ['BDI', '44'], 'Aguardando órgão anuente apresentar documentação fiscal	',
            ['BDI', '50'], 'Objeto roubado	',
            ['BDI', '51'], 'Objeto roubado	',
            ['BDI', '52'], 'Objeto roubado	',
            ['BDI', '53'], 'Objeto reimpresso e reenviado	',
            ['BDI', '54'], 'Aguardando a guia de recolhimento para pagamento do ICMS Importação	Por favor, aguarde.',
            ['BDI', '56'], 'Objeto com declaração aduaneira ausente ou incorreta	Aguarde: objeto em tratamento e sujeito a devolução',
            ['BDI', '60'], 'Objeto encontra-se aguardando prazo para refugo	',
            ['BDI', '61'], 'Objeto refugado	Devolução proibida por órgão anuente ou não contratada pelo remetente',
            ['BDI', '62'], 'Em devolução à origem por determinação da Receita Federal	Objeto poderá ser devolvido à origem ou encaminhado para refugo de acordo com orientação do remetente',
            ['BDI', '71'], 'Objeto apreendido por: ANVISA/VIGILANCIA SANITARIA	O objeto está em poder da autoridade competente',
            ['BDI', '72'], 'Objeto apreendido por: BOMBEIROS	O objeto está em poder da autoridade competente',
            ['BDI', '73'], 'Objeto apreendido por: EXERCITO	O objeto está em poder da autoridade competente',
            ['BDI', '74'], 'Objeto apreendido por: IBAMA	O objeto está em poder da autoridade competente',
            ['BDI', '75'], 'Objeto apreendido por: POLICIA FEDERAL	O objeto está em poder da autoridade competente',
            ['BDI', '76'], 'Objeto apreendido por: POLICIA CIVIL/MILITAR	O objeto está em poder da autoridade competente',
            ['BDI', '77'], 'Evento RFB - Aguardando DTRAT	',
            ['BDI', '80'], 'Objeto não localizado no fluxo postal	',
            ['BDI', '81'], 'Não foi autorizada a saída do objeto do país pelos órgãos fiscalizadores	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDI', '82'], 'Necessário complementar endereço de entrega	Acesse o Fale Conosco > Reclamação > Objeto em processo de desembaraço',
            ['BDI', '83'], 'Ação necessária à liberação do objeto não realizada pelo cliente	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDI', '85'], 'Código do objeto fora do padrão	Objeto será entregue sem rastreamento',
            ['BDI', '86'], 'Objeto com conteúdo avariado	Sem condições de entrega',
            ['BDR', '12'], 'Remetente não retirou objeto na Unidade dos Correios	Objeto em análise de destinação',
            ['BDR', '13'], 'Objeto atingido por incêndio em unidade operacional	',
            ['BDR', '14'], 'Desistência de postagem pelo remetente	',
            ['BDR', '15'], 'Recebido na unidade de distribuição	Por determinação judicial o objeto será entregue em até 7 dias',
            ['BDR', '22'], 'Objeto devolvido aos Correios	',
            ['BDR', '28'], 'Objeto e/ou conteúdo avariado	',
            ['BDR', '30'], 'Saída não efetuada	Em tratamento, aguarde.',
            ['BDR', '33'], 'A entrega não pode ser efetuada - Destinatário não apresentou documento exigido	',
            ['BDR', '37'], 'Objeto e/ou conteúdo avariado por acidente com veículo	',
            ['BDR', '38'], 'Objeto endereçado à empresa falida	Objeto será encaminhado para entrega ao administrador judicial',
            ['BDR', '39'], 'A entrega não pode ser efetuada	Objeto em análise de destinação',
            ['BDR', '40'], 'Não foi autorizada a entrada do objeto no país pelos órgãos fiscalizadores	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDR', '43'], 'Objeto apreendido por órgão de fiscalização	Objeto está em poder da autoridade competente',
            ['BDR', '47'], 'Saída para entrega cancelada	Será efetuada nova saída para entrega',
            ['BDR', '50'], 'Objeto roubado	',
            ['BDR', '51'], 'Objeto roubado	',
            ['BDR', '52'], 'Objeto roubado	',
            ['BDR', '54'], 'Aguardando a guia de recolhimento para pagamento do ICMS Importação	Por favor, aguarde.',
            ['BDR', '55'], 'Solicitação de revisão do tributo	Acesse Minhas Importações para acompanhamento do pedido de revisão',
            ['BDR', '56'], 'Objeto com declaração aduaneira ausente ou incorreta	Aguarde: objeto em tratamento e sujeito a devolução',
            ['BDR', '62'], 'Em devolução à origem por determinação da Receita Federal	Objeto poderá ser devolvido à origem ou encaminhado para refugo de acordo com orientação do remetente',
            ['BDR', '71'], 'Objeto apreendido por: ANVISA/VIGILANCIA SANITARIA	O objeto está em poder da autoridade competente',
            ['BDR', '72'], 'Objeto apreendido por: BOMBEIROS	O objeto está em poder da autoridade competente',
            ['BDR', '73'], 'Objeto apreendido por: EXERCITO	O objeto está em poder da autoridade competente',
            ['BDR', '74'], 'Objeto apreendido por: IBAMA	O objeto está em poder da autoridade competente',
            ['BDR', '75'], 'Objeto apreendido por: POLICIA FEDERAL	O objeto está em poder da autoridade competente',
            ['BDR', '76'], 'Objeto apreendido por: POLICIA CIVIL/MILITAR	O objeto está em poder da autoridade competente',
            ['BDR', '77'], 'Evento RFB - Aguardando DTRAT	',
            ['BDR', '79'], 'POSTAGEM INEXISTENTE	',
            ['BDR', '80'], 'Objeto não localizado no fluxo postal	',
            ['BDR', '81'], 'Não foi autorizada a saída do objeto do país pelos órgãos fiscalizadores	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['BDR', '82'], 'Necessário complementar endereço de entrega	Acesse o Fale Conosco > Reclamação > Objeto em processo de desembaraço',
            ['BDR', '83'], 'Ação necessária à liberação do objeto não realizada pelo cliente	Objeto em análise de destinação - poderá ser devolvido ao remetente, encaminhado para refugo ou apreendido',
            ['FC',  '12'], 'Objeto encaminhado para fiscalização - ANVISA	',
            ['FC',  '19'], 'Objeto encaminhado para fiscalização - ANATEL	',
            ['FC',  '27'], 'Objeto encaminhado para emissão de DSI	',
            ['FC',  '29'], 'Objeto encaminhado para apreensão	',
            ['FC',  '32'], 'Objeto encaminhado para fiscalização - INMETRO	',
            ['FC',  '33'], 'Objeto encaminhado para fiscalização - Polícia Federal	',
            ['FC',  '34'], 'Objeto encaminhado para fiscalização - VIGIAGRO	',
            ['FC',  '35'], 'Objeto encaminhado para fiscalização - Exército	',
            ['FC',  '37'], 'Objeto encaminhado para fiscalização - IBAMA	',
            ['PAR', '21'], 'Encaminhado para fiscalização aduaneira	',
            ['PAR', '22'], 'Encaminhado para fiscalização no país de destino	',
            ['PAR', '28'], 'Encaminhado para a unidade de tratamento	',
            ['FC',  '51'], 'Objeto roubado	',
            ['BDE', '69'], 'Objeto ainda não chegou à unidade	Por favor, aguarde',
            ['BDI', '69'], 'Objeto ainda não chegou à unidade	Por favor, aguarde',
            ['BDR', '69'], 'Objeto ainda não chegou à unidade	Por favor, aguarde',
            ['BDE', '66'], 'Área com distribuição sujeita a prazo diferenciado	Restrição de entrega domiciliar temporária',
            ['BDI', '66'], 'Área com distribuição sujeita a prazo diferenciado	Restrição de entrega domiciliar temporária',
            ['BDR', '66'], 'Área com distribuição sujeita a prazo diferenciado	Restrição de entrega domiciliar temporária',
            ['BDE', '35'], 'Coleta ou entrega de objeto não efetuada	Será realizada nova tentativa de coleta ou entrega',
            ['BDI', '35'], 'Coleta ou entrega de objeto não efetuada	Será realizada nova tentativa de coleta ou entrega',
            ['BDI', '98'], 'Objeto não localizado no fluxo postal.	',
            ['BDR', '29'], 'Objeto não localizado	',
            ['BDR', '35'], 'Coleta ou entrega de objeto não efetuada	Será realizada nova tentativa de coleta ou entrega',
            ['CO',  '13'], 'Objeto não coletado	',
            
            //adicionados por Jose R 20/05/2020 - 01:00 [me cago en mi madre cojone :-(  ]
            ['FC',  '4'], 'Endereço incorreto - Entrega não realizada',
            ['BDI',  '45'], 'Objeto recebido na unidade de distribuição',
            'LDI', '11',    'Objeto encaminhado para retirada no endereço indicado    Para retirá-lo, é preciso informar o código do objeto.',
            'LDI', '13',    'Objeto encaminhado para retirada no endereço indicado    Para retirá-lo, é preciso informar o código do objeto.',
            'LDI', '14',    'Objeto encaminhado para retirada no endereço indicado    Para retirá-lo, é preciso informar o código do objeto.',
            ['BDI',  '34'], 'A entrega não pode ser efetuada - Logradouro com numeração irregular',
            ['BDR',  '34'], 'A entrega não pode ser efetuada - Logradouro com numeração irregular',

        ];

        return $Events;

    // 'BDE', '1',      'Objeto entregue ao destinatário    ',
            // 'BDE', '15',    'Recebido na unidade de distribuição    Por determinação judicial o objeto será entregue em até 7 dias',
            // 'BDE', '23',    'Objeto entregue ao remetente    ',
            // 'BDE', '24',    'Objeto disponível para retirada em Caixa Postal    ',
            // 'BDE', '30',    'Saída não efetuada    Em tratamento, aguarde.',
            // 'BDE', '32',    'Objeto com data de entrega agendada    ',
            // 'BDE', '41',    'A entrega do objeto está condicionada à composição do lote    ',
            // 'BDE', '45',    'Objeto recebido na unidade de distribuição    Entrega prevista para o próximo dia útil',
            // 'BDE', '46',    'Tentativa de entrega não efetuada    Entrega prevista para o próximo dia útil',
            // 'BDE', '47',    'Saída para entrega cancelada    Será efetuada nova saída para entrega',
            // 'BDE', '53',    'Objeto reimpresso e reenviado    ',
            // 'BDE', '57',    'Revisão de tributo concluída - Objeto liberado    ',
            // 'BDE', '58',    'Revisão de tributo concluída - Tributo alterado    O valor do tributo pode ter aumentado ou diminuído',
            // 'BDE', '59',    'Revisão de tributo concluída - Tributo mantido    Poderá haver incidência de juros e multa',
            // 'BDE', '67',    'Objeto entregue ao destinatário    Entrega realizada em endereço vizinho, conforme autorizado pelo remetente',
            // 'BDE', '68',    'Objeto entregue na Caixa de Correios Inteligente    ',
            // 'BDE', '70',    'Objeto entregue ao destinatário    ',
            // 'BDI', '1',      'Objeto entregue ao destinatário    ',
            // 'BDI', '15',    'Recebido na unidade de distribuição    Por determinação judicial o objeto será entregue em até 7 dias',
            // 'BDI', '22',    'Objeto devolvido aos Correios    ',
            // 'BDI', '23',    'Objeto entregue ao remetente    ',
            // 'BDI', '24',    'Objeto disponível para retirada em Caixa Postal    ',
            // 'BDI', '32',    'Objeto com data de entrega agendada    ',
            // 'BDI', '41',    'A entrega do objeto está condicionada à composição do lote    ',
            // 'BDI', '45',    'Objeto recebido na unidade de distribuição    Entrega prevista para o próximo dia útil',
            // 'BDI', '46',    'Tentativa de entrega não efetuada    Entrega prevista para o próximo dia útil',
            // 'BDI', '47',    'Saída para entrega cancelada    Será efetuada nova saída para entrega',
            // 'BDI', '55',    'Solicitação de revisão do tributo    Acesse Minhas Importações para acompanhamento do pedido de revisão',
            // 'BDI', '57',    'Revisão de tributo concluída - Objeto liberado    ',
            // 'BDI', '58',    'Revisão de tributo concluída - Tributo alterado    O valor do tributo pode ter aumentado ou diminuído',
            // 'BDI', '59',    'Revisão de tributo concluída - Tributo mantido    Poderá haver incidência de juros e multa',
            // 'BDI', '67',    'Objeto entregue ao destinatário    Entrega realizada em endereço vizinho, conforme autorizado pelo remetente',
            // 'BDI', '68',    'Objeto entregue na Caixa de Correios Inteligente    ',
            // 'BDI', '70',    'Objeto entregue ao destinatário    ',
            // 'BDI', '84',    'Verificando situação do objeto    Por favor, aguarde',
            // 'BDI', '87',    'Objeto destinado a outro país    ',
            // 'BDR', '1',      'Objeto entregue ao destinatário    ',
            // 'BDR', '23',    'Objeto entregue ao remetente    ',
            // 'BDR', '24',    'Objeto disponível para retirada em Caixa Postal    ',
            // 'BDR', '25',    'Empresa sem expediente - Entrega não realizada    Entrega deverá ocorrer no próximo dia útil',
            // 'BDR', '31',    'Pagamento confirmado    Entrega em até 40 dias úteis',
            // 'BDR', '32',    'Objeto com data de entrega agendada    ',
            // 'BDR', '41',    'A entrega do objeto está condicionada à composição do lote    ',
            // 'BDR', '44',    'Aguardando órgão anuente apresentar documentação fiscal    ',
            // 'BDR', '45',    'Objeto recebido na unidade de distribuição    Entrega prevista para o próximo dia útil',
            // 'BDR', '46',    'Tentativa de entrega não efetuada    Entrega prevista para o próximo dia útil',
            // 'BDR', '53',    'Objeto reimpresso e reenviado    ',
            // 'BDR', '57',    'Revisão de tributo concluída - Objeto liberado    ',
            // 'BDR', '58',    'Revisão de tributo concluída - Tributo alterado    O valor do tributo pode ter aumentado ou diminuído',
            // 'BDR', '59',    'Revisão de tributo concluída - Tributo mantido    Poderá haver incidência de juros e multa',
            // 'BDR', '60',    'Objeto encontra-se aguardando prazo para refugo    ',
            // 'BDR', '61',    'Objeto refugado    Devolução proibida por órgão anuente ou não contratada pelo remetente',
            // 'BDR', '63',    'Pagamento não efetuado no prazo    Objeto em análise de destinação',
            // 'BDR', '67',    'Objeto entregue ao destinatário    Entrega realizada em endereço vizinho, conforme autorizado pelo remetente',
            // 'BDR', '68',    'Objeto entregue na Caixa de Correios Inteligente    ',
            // 'BDR', '70',    'Objeto entregue ao destinatário    ',
            // 'BDR', '84',    'Verificando situação do objeto    Por favor, aguarde',
            // 'BDR', '85',    'Código do objeto fora do padrão    Objeto será entregue sem rastreamento',
            // 'BDR', '86',    'Objeto com conteúdo avariado    Sem condições de entrega',
            // 'BDR', '87',    'Objeto destinado a outro país    ',
            // 'BLQ', '1',      'Solicitação de suspensão de entrega recebida    Solicitação realizada pelo contratante/remetente',
            // 'BLQ', '4',      'Bloqueio    ',
            // 'BLQ', '5',      'Solicitação de suspensão de entrega recebida    Objeto deve retornar ao Centro Internacional',
            // 'BLQ', '11',    'Solicitação de suspensão de entrega recebida    Solicitação realizada pelo contratante/remetente',
            // 'BLQ', '21',    'Solicitação de suspensão de entrega recebida    ',
            // 'BLQ', '22',    'Solicitação de suspensão de entrega recebida    ',
            // 'BLQ', '24',    'Desbloqueio de objeto indenizado    ',
            // 'BLQ', '30',    'Bloqueio teste    ',
            // 'BLQ', '31',    'Extravio varejo pós-indenizado    ',
            // 'BLQ', '41',    'Bloqueio SEGOPE 4/1    ',
            // 'BLQ', '42',    'Bloqueio SEGOPE 4/2    ',
            // 'BLQ', '44',    'Desbloqueio de objeto com conteúdo proibido/perigoso    ',
            // 'BLQ', '51',    'Objeto bloqueado por necessidade de revisão de impostos/tributos    ',
            // 'BLQ', '54',    'Desbloqueio de objeto com revisão de impostos/tributos    ',
            // 'BLQ', '61',    'Desbloqueado    ',
            // 'CO',  '1',      'Objeto coletado    ',
            // 'CO',  '2',      'A coletar    ',
            // 'CO',  '3',      'Coletando    ',
            // 'CO',  '4',      'Pedido Transferido    ',
            // 'CO',  '5',      '1ª Tentativa de Coleta    ',
            // 'CO',  '6',      '2ª Tentativa / Coleta Cancelada    ',
            // 'CO',  '7',      'Aguardando Objeto na Agência    ',
            // 'CO',  '8',      'Entregue    ',
            // 'CO',  '9',      'Coleta Cancelada    ',
            // 'CO',  '10',    'Desistência do Cliente ECT    ',
            // 'CO',  '11',    'Objeto Sinistrado    ',
            // 'CO',  '12',    'Aguardando Objeto de Entrega    ',
            // 'CO',  '14',    'Transformado em e-ticket    ',
            // 'DO',  '1',      'Objeto encaminhado     ',
            // 'DO',  '2',      'Objeto encaminhado     ',
            // 'EST', '1',      'Favor desconsiderar a informação anterior    ',
            // 'EST', '2',      'Favor desconsiderar a informação anterior    ',
            // 'EST', '3',      'Favor desconsiderar a informação anterior    ',
            // 'EST', '4',      'Favor desconsiderar a informação anterior    ',
            // 'EST', '5',      'Favor desconsiderar a informação anterior    ',
            // 'EST', '6',      'Favor desconsiderar a informação anterior    ',
            // 'EST', '9',      'Favor desconsiderar a informação anterior    ',
            // 'FC    ', '1',      'Objeto será devolvido por solicitação do contratante/remetente    Em tratamento, aguarde.',
            // 'FC    ', '2',      'Objeto com data de entrega agendada    Em tratamento, aguarde.',
            // 'FC    ', '5',      'Objeto devolvido aos Correios    ',
            // 'FC    ', '7',      'Empresa sem expediente - Entrega não realizada    Entrega deverá ocorrer no próximo dia útil',
            // 'FC    ', '9',      'Remetente não retirou objeto na Unidade dos Correios    Objeto em análise de destinação',
            // 'FC    ', '10',    'Objeto recebido na unidade de distribuição    Entrega deverá ocorrer no próximo dia útil',
            // 'FC    ', '11',    'Objeto destruído com autorização do remetente    ',
            // 'FC    ', '13',    'Fiscalizado ANATEL    Seguir orientações do site da ANATEL. Prazo: 10 dias corridos',
            // 'FC    ', '24',    'Em fiscalização pela Receita Federal    ',
            // 'FC    ', '26',    'RFB - Objeto Tributado - Emissão da nota de tributação    ',
            // 'FC    ', '31',    'Aguardando autorização para exportação    ',
            // 'FC    ', '42',    'Objeto contém líquido, impossibilitando seu transporte    Em tratamento, aguarde',
            // 'FC    ', '47',    'Objeto será devolvido por solicitação do contratante/remetente    Em tratamento, aguarde.',
            // 'FC    ', '55',    'Encomenda unitizada finalizada    ',
            // 'LDI', '2',      'Objeto disponível para retirada em Caixa Postal    ',
            // 'LDI', '11',    'Objeto encaminhado para retirada no endereço indicado    Para retirá-lo, é preciso informar o código do objeto.',
            // 'LDI', '13',    'Objeto encaminhado para retirada no endereço indicado    Para retirá-lo, é preciso informar o código do objeto.',
            // 'LDI', '14',    'Objeto encaminhado para retirada no endereço indicado    Para retirá-lo, é preciso informar o código do objeto.',
            // 'OEC', '1',      'Objeto saiu para entrega ao destinatário    ',
            // 'OEC', '9',      'Objeto saiu para entrega ao remetente    ',
            // 'PAR', '10',    'Fiscalização aduaneira finalizada    ',
            // 'PAR', '11',    'Aguardando pagamento    ',
            // 'PAR', '12',    'Informações prestadas pelo cliente em análise    ',
            // 'PAR', '13',    'Objeto devolvido ao país de origem    ',
            // 'PAR', '14',    'Revisão de tributos solicitada pelo cliente    ',
            // 'PAR', '15',    'Objeto recebido em    ',
            // 'PAR', '16',    'Objeto recebido pelos Correios do Brasil    ',
            // 'PAR', '17',    'Aguardando pagamento    ',
            // 'PAR', '18',    'Objeto recebido na unidade de exportação no país de origem    ',
            // 'PAR', '19',    'Fiscalização aduaneira finalizada no país de destino    ',
            // 'PAR', '20',    'Objeto recebido pelos Correios do Brasil com embalagem danificada    Por favor, aguarde',
            // 'PAR', '23',    'Aguardando autorização da Receita Federal para devolução do objeto ao remetente    ',
            // 'PAR', '24',    'Devolução autorizada pela Receita Federal    ',
            // 'PAR', '25',    'Faltam informações. Sua ação é necessária    ',
            // 'PAR', '26',    'Destinatário recusou o objeto    Objeto em análise de destinação',
            // 'PAR', '27',    'Despacho Postal pago na origem    ',
            // 'PAR', '29',    'PAR 29    ',
            // 'PAR', '30',    'Aguardando pagamento do despacho postal    ',
            // 'PAR', '31',    'Pagamento confirmado    ',
            // 'PAR', '32',    'Aguardando confirmação de pagamento pela operadora    ',
            // 'PAR', '33',    'Pagamento não confirmado pela operadora    Entre em contato com sua operadora',
            // 'PAR', '34',    'Liberado sem tributação    ',
            // 'PAR', '41',    'Prazo de pagamento encerrado    Objeto em análise de destinação',
            // 'PAR', '42',    'Objeto liberado    ',
            // 'PO    ', '1',      'Objeto postado    ',
            // 'PO    ', '9',      'Objeto postado após o horário limite da unidade    Sujeito a encaminhamento no próximo dia útil',
            // 'RO    ', '1',      'Objeto encaminhado     ',

        }
}

/**

result: array:1 [▼
0 => PhpSigep\Model\RastrearObjetoResultado {#903 ▼
#etiqueta: PhpSigep\Model\Etiqueta {#904 ▼
#etiquetaComDv: "SI192420171BR"
#etiquetaSemDv: null
#dv: null
#_failIfAtributeNotExiste: true
}
#eventos: array:6 [▼
0 => PhpSigep\Model\RastrearObjetoEvento {#905 ▼
#tipo: "BDR"
#status: "01"
#dataHora: "2020-03-03 17:00"
#descricao: "Objeto entregue ao destinatário"
#recebedor: ""
#detalhe: ""
#local: "AC MOGI DAS CRUZES"
#codigo: "08710971"
#cidade: "MOGI DAS CRUZES"
#uf: "SP"
#error: null
#_failIfAtributeNotExiste: true
}
1 => PhpSigep\Model\RastrearObjetoEvento {#906 ▼
#tipo: "LDI"
#status: "01"
#dataHora: "2020-03-03 12:40"
#descricao: "Objeto aguardando retirada no endereço indicado"
#recebedor: ""
#detalhe: "Para retirá-lo, é preciso informar o código do objeto e apresentar documentação que comprove ser o destinatário ou pessoa por ele oficialmente autorizada."
#local: "AC MOGI DAS CRUZES"
#codigo: "08710971"
#cidade: "MOGI DAS CRUZES"
#uf: "SP"
#error: null
#_failIfAtributeNotExiste: true
}
4 => PhpSigep\Model\RastrearObjetoEvento {#909 ▼
#tipo: "RO"
#status: "01"
#dataHora: "2020-03-02 17:05"
#descricao: "Objeto encaminhado "
#recebedor: ""
#detalhe: ""
#local: "AC INDIANOPOLIS"
#codigo: "04082970"
#cidade: "Sao Paulo"
#uf: "SP"
#error: null
#_failIfAtributeNotExiste: true
}
5 => PhpSigep\Model\RastrearObjetoEvento {#910 ▼
#tipo: "PO"
#status: "01"
#dataHora: "2020-03-02 17:01"
#descricao: "Objeto postado"
#recebedor: ""
#detalhe: ""
#local: "AC INDIANOPOLIS"
#codigo: "04082970"
#cidade: "Sao Paulo"
#uf: "SP"
#error: null
#_failIfAtributeNotExiste: true
}
]
#_failIfAtributeNotExiste: true
}
]
 */
