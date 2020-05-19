<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CopyAndDeleteLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:copyedelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command copies laravel log to a specific place and delete';

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
        $today = Carbon::now()->format('d-m-Y');
        $pathlog = storage_path('logs/laravel.log');
        $newpath = public_path('logs/'.$today.'.log');

        File::copy($pathlog, $newpath);
        
        
        exec('echo "" > ' . storage_path('logs/laravel.log'));
        $this->info('Logs have been cleared');
    }
}
