<?php

namespace App\Business;

use App\Http\Controllers\StatusController;
use App\Models\Company;
use App\Models\Objects;
use App\Models\Tracking;
use App\Repositories\TrackingRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

            $trackingBussines = new TrackingBusiness();
            foreach ($Companies as $key => $Company) {
                $Objects = $this->getTrackingCompanyNextObjects($Company);

                $now = Carbon::now();
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

          $Objects = $TrackingModel->where('status_id', '!=', StatusController::RECEIVED)->orderBy('updated_at', 'asc')->get()->slice(0, env('APP_TRACKING_MESSAGES_X_MINUTE', 10));

          return $Objects;
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
    }

    function importCSV(UploadedFile $file, DateTime $date = null) : bool
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

          foreach ($Trackings as $key => $Objects) {
            $trackingBussines = new TrackingBusiness();
            $trackingBussines->createTracking($Objects, $Company);
          }

        return true;
      } catch (\Throwable $th) {
        // MyResponse::makeExceptionJson($th);
      }

      return false;
    }

    public function csv_to_array($filename='', $delimiter=';') : ?array
    {
      try {
        if(!file_exists($filename) || !is_readable($filename))
          return NULL;
        
        $header = array();
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
          $header = fgetcsv($handle, 0, $delimiter);
          // while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE)
          while (($row = fgets($handle)) !== FALSE)
          {
            $row = html_entity_decode($row);
            $row = explode($delimiter,$row);

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