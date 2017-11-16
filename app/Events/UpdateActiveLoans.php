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
                    ->whereIn('loans.loan_status_id', [1,3])
                    ->whereIn('loans.remittance_date_id', $arr_date)
                    ->select('id', 'remittance_date_id')
                    ->get();
            // Set the loan counter
            $inserted_loans_ctr = 0;
            // Insert each of the ids of all the returned loan records
            foreach($query as $loan)
            {
                // $arr_id[] = $loan->id;
                // Check if the current loan is already in the active table (late)
                if(! check_active_duplicate($loan->id))
                {

                    // Check if the active loan has an early remittance
                    $check_if_early = DB::table('early_loan_remittances')
                                ->where([
                                    ['loan_id', $loan->id],
                                    ['isChecked', 0],                                    
                                ])
                                ->select('loan_id')
                                ->exists();

                    // If the loan doesn't have any early remittances
                    if(! $check_if_early)
                    {
                        // Insert the new loan into the active table
                        $insert_to_active = DB::table('active_remittable_loans')
                                      ->insert([
                                        [
                                            'loan_id' => $loan->id,
                                            'remittance_date_id' => $loan->remittance_date_id,
                                            'date' => Carbon::today('Asia/Manila')->format('Y-m-d')
                                        ]
                                      ]);
                    }
                    // If it does, checked it off
                    else
                    {
                        $remove_early = DB::table('early_loan_remittances')
                                        ->where('loan_id', $loan->id)
                                        ->update(['isChecked' => 1]);
                    }                    
                }

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
