<?php

namespace App\Console\Commands;

use App\Events\UpdateActiveLoans;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check current date if it is one of the recorded remittance dates.';

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
        
        // // Return the result of the operation and how many records were inserted
        // if($inserted_loans_ctr != 0)
        //     $this->info($inserted_loans_ctr.' records was inserted successfully');
        // else
        //     $this->info('No records was inserted');

        // $this->info($arr_date[1]);

        $this->info(event(new UpdateActiveLoans));
    }
}
