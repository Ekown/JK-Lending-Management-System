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
    public $remittanceAmount;
    public $updateLoanStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($loanId, $remittanceAmount, $isRemittance = true)
    {
        $this->loanId = $loanId;
        $this->remittanceAmount = $remittanceAmount;
        $this->isRemittance = $isRemittance;

        // If the event is fired by a remittance
        if($isRemittance == true)
        {
            // Gets the current total remittances for the given loan
            $totalRemittances = DB::table('loan_remittances')
                                ->selectRaw('SUM(loan_remittances.amount) as sum')
                                ->where('loan_remittances.loan_id', $loanId)
                                ->first();

            // Gets the current total remaining balance for the given loan
            $loanBalance = DB::table('loans')
                            ->select('loans.interested_amount')
                            ->where('loans.id', $loanId)
                            ->first();

            // Gets the current cumulative late remittance amount for the given loan
            $totalLateBalance = DB::table('late_remittance_amount')
                                ->select('amount')
                                ->where('loan_id', $loanId)
                                ->first();

            // If the current total remittances is greater than or equal to the current remaining 
            // balance, change the loan status to 'Paid'
            if($totalRemittances->sum >= $loanBalance->interested_amount)
            {
                $this->updateLoanStatus = "Paid";
                $this->changeStatus(2);

                // If the loan record has a late remittance record
                if($totalLateBalance != null)
                {
                    // Deletes the loan's late remittance record from the database
                    $this->deleteLateBalance($loanId);
                }

                $this->removeFromActive($loanId);
            }
            // If else, change or retain the loan status to 'Not Fully Paid'
            else
            {
                // If there are no late remittance amount for the loan
                if($totalLateBalance == null)
                {
                    // Update the loan status to 'Not Fully Paid'
                    $this->notFullyPaid($loanId);
                }
                // Else, if there are late remittance amount for the loan
                else
                {
                    // If the remittance is greater than or equal to the total cumulative late remittance
                    if($remittanceAmount >= $totalLateBalance->amount)
                    {
                        // Update the loan status to 'Not Fully Paid'
                        $this->notFullyPaid($loanId);

                        // Deletes the loan's late remittance record from the database
                        $this->deleteLateBalance($loanId);
                    }
                    else
                    {
                        // Deduct the remittance to the total cumulative late remittance amount
                        $deductFromLate = DB::table('late_remittance_amount')
                                          ->where('loan_id', $loanId)
                                          ->update([
                                            'amount' => ($totalLateBalance->amount - $remittanceAmount)
                                          ]);

                        // Update the loan status to 'Late'
                        $this->updateLoanStatus = "Late";
                        $this->changeStatus(3);
                    }

                }
                
            }
        }
        else
        {
            $this->updateLoanStatus = "Late";
        }
    }

    public function changeStatus($status)
    {
        (new LoanController)->updateLoanStatus($status, $this->loanId);
    }

    public function deleteLateBalance($id)
    {
        $deleteLateBalance = DB::table('late_remittance_amount')
                               ->where('loan_id', $id)
                               ->delete();
    }

    public function notFullyPaid($id)
    {
        // Update the loan status to 'Not Fully Paid'
        $this->updateLoanStatus = "Not Fully Paid";
        $this->changeStatus(1);

        $this->removeFromActive($id);
    }

    public function removeFromActive($id)
    {
        // If the current loan is in the active remittance table
        if(check_active_duplicate($id))
        {
            // Deletes the loan's active remittance record from the database
            $deleteLateBalance = DB::table('active_remittable_loans')
                                    ->where('loan_id', $id)
                                    ->delete();
        }
    } 

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        // If the loan is paid or not fully paid, broadcast to the Loan and Loan Master List Channels
        if($this->updateLoanStatus == "Paid" || $this->updateLoanStatus == "Not Fully Paid")
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
