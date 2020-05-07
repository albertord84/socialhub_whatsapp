<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Create_company_tracking_jobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Create_company_tracking_jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to get tracking and create tracking jobs.';

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
        //
    }
}
