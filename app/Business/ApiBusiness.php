<?php

namespace App\Business;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ExternalRPIController;
use App\Jobs\SendWhatsAppMsgApi;
use App\Models\Api;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Status;
use App\Repositories\ApiRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use stdClass;

class ApiBusiness extends Business
{

    public function __construct()
    {
        parent::__construct();

        $this->repo = new ApiRepository(app());
    }

    public function getCompanies(): Collection
    {
        $Apis = new Collection();
        try {
            $Companies = Company::with('rpi')->where(['api_contrated' => true])->get();

            return $Companies;
        } catch (\Throwable $tr) {
            throw $tr;
        }

        return $Apis;
    }

    public function createCompaniesJobs()
    {
        $Apis = new Collection();
        try {
            $Companies = Company::with('rpi')->where(['api_contrated' => true])->get();

            foreach ($Companies as $key => $Company) {
                $Apis = $this->getApiCompanyNextObjects($Company);

                $ExternalRPIController = new ExternalRPIController($Company->rpi);

                // dd($Apis);

                foreach ($Apis as $key => $Api) {
                    $this->createApiJob($Api, $ExternalRPIController);
                }
            }
        } catch (\Throwable $tr) {
            throw $tr;
        }

        return $Apis;
    }

    public function getApiCompanyNextObjects(Company $Company): Collection
    {
        try {
            $ApiModel = new Api();
            $ApiModel->table = "$Company->id";
            
            $Apis = $ApiModel->where('status_id', ApiController::RECEIVED)->orderBy('updated_at', 'asc')->get()->take(env('APP_API_MESSAGES_X_MINUTE', 20));

            return $Apis;
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
    }


    public function createApiJob(Api $Api, ExternalRPIController $ERPIC)
    {
        try {
            $Contact = Contact::find($Api->contact_id);

            if ($Contact) {
                $Api = $Api->toArray();
                
                SendWhatsAppMsgApi::dispatch($ERPIC, $Contact, $Api, 'api_messages');
                // $apiJob = new SendWhatsAppMsgApi($ERPIC, $Contact, $Api);
                // $apiJob->handle();
            
            } else {
                throw new \Exception("createApiSendWhatsAppMsgApiJob Contact($Api->contact_id) not found in Api ($Api->id)");
            }

        } catch (\Throwable $tr) {
            Log::debug('ApiSendWhatsAppMsgApisBussines createApiSendWhatsAppMsgApi Job', [$tr]);
            return false;
        }

        return true;
    }

    public function importCSV(UploadedFile $file, DateTime $date = null): array
    {
        // $file = $file ?? Storage::disk('chats_files_1')->get('storage/Pedidos.csv');
        // $objCodeCol = 'envioRastreamento';
        try {
            $User = Auth::check() ? Auth::user() : session('logged_user');

            $Company = Company::find($User->company_id);

            // if (File::isFile($file)) {
            // Convert the file content to a Apis array
            // $Apis = $this->csv_to_array('/var/www/html/app.socialhub.local/public/storage/Pedidos.csv', ';');
            $Apis = $this->csv_to_array($file->getRealPath());
            // var_dump($Apis);
            
            $response = array(
                'criated' => 0,
                'already_exist' => 0,
                'exception' => 0
            );

            foreach ($Apis as $key => $Apis) {
                $apiBussines = new ApiBusiness();
                $result = $apiBussines->createApi($Apis, $Company);
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

}
