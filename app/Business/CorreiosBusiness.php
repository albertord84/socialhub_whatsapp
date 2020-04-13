<?php

namespace App\Business;

use App\Models\Company;
use App\Models\Tracking;
use App\Repositories\TrackingRepository;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Carbon;

class CorreiosBusiness extends Business
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

            $trackingBussines = new TrackingBusiness();
            foreach ($Companies as $key => $Company) {
                $Tracking = $this->getTrackingCompanyNextObject($Company);

                if ($Tracking->updated_at < Carbon::today()) { // Verify whether not checked today
                  $trackingBussines->createTrackingJob($Tracking, $Company);
                }
            }
        } catch (\Throwable $tr) {
            throw $tr;
        }

        return $Objects;
    }

    public function getTrackingCompanyNextObject(Company $Company): Tracking
    {
        $Tracking = new Tracking();
        $Tracking->table = "$Company->id";

        try {
          $Tracking = $Tracking->last();

          return $Tracking;
        } catch (\Throwable $th) {
            MyResponse::makeExceptionJson($th);
        }
    }

    function importCSV(File $file, DateTime $date) : bool
    {
      try {
        $User = Auth::check() ? Auth::user() : session('logged_user');

        $Company = Company::find($User->company_id);

        if (File::isFile($file)) {
          // Convert the file content to a Tracking array
          $Tracking = $this->csv_to_array($file->getRealPath(), ';');
          if (count($Tracking) > 1 ) {
              $Tracking = $this->csv_to_array($file->getRealPath(), ',');
          }

          for ($i = 3; $i < $Tracking; $i++) {
            if ($Tracking[$i][2] == $date) {
              $trackingBussines = new TrackingBusiness();
              $trackingBussines->createTracking($Tracking[$i], $Company);
            }
          }
          
          unlink($file->getPath());
        }

        return true;
      } catch (\Throwable $th) {
        MyResponse::makeExceptionJson($th);
      }
    }

    public function csv_to_array($filename='', $delimiter=',') : ?array
    {
        if(!file_exists($filename) || !is_readable($filename))
            return NULL;
        
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
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