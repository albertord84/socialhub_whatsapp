<?php

namespace App\Console\Commands;

use App\Business\BlingBusiness;
use App\Business\MyResponse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Get_sales_bling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Get_sales_bling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to get bling sales to every company and dispatch jobs';

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
            $BlingBussines = new BlingBusiness();
            
            $Sales = $BlingBussines->getBlingSales(true);
            
            Log::debug('Bling Sales', [$Sales]);


        } catch (\Throwable $tr) {
            return MyResponse::makeExceptionJson($tr);
        }

        return $Sales->toJson();
    }
}
