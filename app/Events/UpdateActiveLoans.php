<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateActiveLoans implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        // Ready the active remittance table for insertion
        ready_active_table();        

        // Get the corresponding remittance date id of current date
        $arr_date = remittance_date_id();

        // If the current date has a corresponding remittance date, get all the loans with the 
        // correspoding remittance date and insert each of their loan id into the active remittance
        // table
        if($arr_date != null)
        {
            // Get all the loans with the corresponding remittance date
            $query = DB::table('loans')
                    ->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->leftJoin('cash_advance_status', 'loans.cash_advance_status_id', '=', 'cash_advance_status.id')
                    ->leftJoin('term_type', 'loans.term_type_id', '=', 'term_type.id')
                    ->leftJoin('loan_status', 'loans.loan_status_id', '=', 'loan_status.id')
                    ->whereIn('loans.loan_status_id', [1,3])
                    ->whereIn('loans.remittance_date_id', $arr_date)
                    ->select('loans.*', 'borrowers.name as borrower_name', 'companies.name as company_name', 'cash_advance_status.name as cash_advance_status', 'term_type.name as term_type', 'loan_status.name as loan_status');

            // Set the loan counter
            $inserted_loans_ctr = 0;

            // Insert each of the ids of all the returned loan records
            foreach($query->get() as $loan)
            {
                // $arr_id[] = $loan->id;

                $insert_to_active = DB::table('active_remittable_loans')
                                      ->insert([
                                        [
                                            'loan_id' => $loan->id,
                                            'remittance_date_id' => $loan->remittance_date_id,
                                            'date' => Carbon::today('Asia/Manila')->format('Y-m-d')
                                        ]
                                      ]);

                // Increment the counter for each inserted record
                $inserted_loans_ctr++;
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('loanMasterListChannel');
    }
}
