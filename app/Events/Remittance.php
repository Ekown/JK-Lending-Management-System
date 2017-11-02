<?php

namespace App\Events;

use App\Http\Controllers\LoanController;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class Remittance implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loanId;

    public $updateLoanStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($loanId)
    {
        $this->loanId = $loanId;

        // Gets the current total remittances for the given loan
        $totalRemittances = DB::table('loan_remittances')
                            ->selectRaw('SUM(loan_remittances.amount) as sum')
                            ->where('loan_remittances.loan_id', $loanId)
                            ->get();

        // Gets the current total remaining balance for the given loan
        $loanBalance = DB::table('loans')
                        ->select('loans.interested_amount')
                        ->where('loans.id', $loanId)
                        ->get();

        // If the current total remittances is greater than or equal to the current remaining 
        // balance, change the loan status to 'Paid'
        if($totalRemittances->first()->sum >= $loanBalance->first()->interested_amount)
        {
            $this->updateLoanStatus = "Paid";
            (new LoanController)->updateLoanStatus(2, $loanId);
        }
        // If else, change or retain the loan status to 'Not Fully Paid'
        else
        {
            $this->updateLoanStatus = "Not Fully Paid";
            (new LoanController)->updateLoanStatus(1, $loanId);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        // If the loan is paid, broadcast to the Loan and Loan Master List Channels
        if($this->updateLoanStatus == "Paid")
        {
            return [
                new PrivateChannel('loanChannel.'.$this->loanId),
                new PrivateChannel('loanMasterListChannel')
            ];
        }
        // If else, broadcast only on the Loan Channel
        else
        {
            return new PrivateChannel('loanChannel.'.$this->loanId);
        }
        

    }
}
