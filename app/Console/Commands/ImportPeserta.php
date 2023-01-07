<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ParticipantGoogleForm;
use Maatwebsite\Excel\Facades\Excel;

class ImportPeserta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'googleform';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Peserta dari Google Form';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Excel::import(new ParticipantGoogleForm, storage_path('konfer.xlsx'));
        return Command::SUCCESS;
    }
}
