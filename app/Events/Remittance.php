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

        $totalRemittances = DB::table('loan_remittances')
                            ->selectRaw('SUM(loan_remittances.amount) as sum')
                            ->where('loan_remittances.loan_id', $loanId)
                            ->get();

        $loanBalance = DB::table('loans')
                        ->select('loans.interested_amount')
                        ->where('loans.id', $loanId)
                        ->get();

        if($totalRemittances->first()->sum >= $loanBalance->first()->interested_amount)
        {
            $this->updateLoanStatus = "Paid";
            (new LoanController)->updateLoanStatus(2, $loanId);
        }
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

        // Broadcast to the Loan and Loan Master List Channels
        if($this->updateLoanStatus == "Paid")
        {
            return [
                new PrivateChannel('loanChannel.'.$this->loanId),
                new PrivateChannel('loanMasterListChannel')
            ];
        }
        else
        {
            return new PrivateChannel('loanChannel.'.$this->loanId);
        }
        

    }
}
