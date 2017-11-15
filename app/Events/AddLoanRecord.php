<?php

namespace App\Events;

use App\Http\Controllers\LoanController;
use App\Http\Controllers\RemittanceController;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AddLoanRecord implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $borrowerId;
    public $loanId;
    public $borrower;

    public function __construct($borrowerId, $loanId)
    {
        $this->borrowerId = $borrowerId;
        $this->loanId = $loanId;

        // Get the borrower for the loan
        $getBorrowerName = DB::table('loans')
                        ->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
                        ->where('loans.id', $this->loanId)
                        ->select('borrowers.name')
                        ->first();

        // Store the borrower's name
        $this->borrower = $getBorrowerName->name;

        $loan = (new LoanController)->getLoanDetails($loanId)->first();

        $remittanceDateArray = (new RemittanceController)->getDates();

        foreach ($remittanceDateArray as $date) 
        {
            if($loan->remittance_date_id == $date->id) 
            {
                $finalRemittanceDateArray = explode('/', $date->remittance_date);

                break;
            }
        }

        $dueDate = getDueDate((int)Carbon::now()->day, (float)$loan->term, $finalRemittanceDateArray, 
            (int)$loan->term_type_id);

        (new LoanController)->updateDueDate($loan->id, $dueDate->format('Y-m-d'));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('loanMasterListChannel'),
            new PrivateChannel('borrowerChannel.'.$this->borrowerId)
        ];
    }
}
