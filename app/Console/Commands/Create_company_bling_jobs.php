<?php

namespace App\Console\Commands;

use App\Business\MyResponse;
use App\Business\SalesBusiness;
use App\Http\Controllers\ExternalRPIController;
use App\Jobs\SendWhatsAppMsgBling;
use Illuminate\Console\Command;

class Create_company_bling_jobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Create_company_bling_jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            // dd("ok  ");
            
            $SaleBusiness = new SalesBusiness();

            $SaleBusiness->createCompaniesJobs();

        } catch (\Throwable $th) {
            return MyResponse::makeExceptionJson($th);
        }

        return MyResponse::makeResponseJson("ok");
    }
}

