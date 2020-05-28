<?php

namespace App\Console\Commands;

use App\Business\ApiBusiness;
use App\Business\MyResponse;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class Create_company_api_jobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_company_api_jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create jobs to Api companies.';

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
    public function handle(Request $request)
    {
        try {
            // dd("ok  ");
            
            $APIBusiness = new ApiBusiness();

            $APIBusiness->createCompaniesJobs();

        } catch (\Throwable $th) {
            return MyResponse::makeExceptionJson($th);
        }

        return MyResponse::makeResponseJson("ok");
    }
}
