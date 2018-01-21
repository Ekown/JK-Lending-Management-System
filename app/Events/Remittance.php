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

class Remittance implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loanId;
    public $remittanceAmount;
    public $updateLoanStatus;
    public $remittanceBorrower;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($loanId, $remittance, $isRemittance = true)
    {
        $this->loanId = $loanId;

        if($remittance != null)
            $this->remittanceAmount = $remittance->amount;
        
        $this->isRemittance = $isRemittance;

        // If the event is fired by a remittance
        if($isRemittance == true)
        {

            // Check if the current loan is active or late
            $checkIfActive = DB::table('active_remittable_loans')
                                ->where('loan_id', $loanId)  
                                ->select('loan_id')
                                ->exists(); 

            // Check if a remittance has been made in the same date
            $checkIfRemitted = DB::table('early_loan_remittances')  
                                ->where([
                                    ['loan_id', $loanId],
                                    ['date', $remittance->date]
                                ])  
                                ->select('id')
                                ->exists();   

            // Check if the remittance is a past remittance
            $checkifPastRemit = (Carbon::parse($remittance->date) <= Carbon::today());  

            // If the current loan is not active or late, then this is an early remittance
            if($checkIfActive == false && $checkIfRemitted == false && $checkifPastRemit == false)
            {
                // Add the remittance to the early remittance table
                $addToEarly = DB::table('early_loan_remittances')
                            ->insert([
                                [
                                    'loan_id' => $loanId,
                                    'date' => $remittance->date
                                ]
                            ]);
            }

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
            elseif($remittance->amount >= get_deduction($loanId)->deduction)
            {
                // If there are no late remittance amount for the loan
                if($totalLateBalance == null)
                {
                    // Update the loan status to 'Not Fully Paid'
                    $this->notFullyPaid($loanId);
                    $this->removeFromActive($loanId);
                }
                // Else, if there are late remittance amount for the loan
                else
                {
                    // If the remittance is greater than or equal to the total cumulative late remittance
                    if($remittance->amount >= $totalLateBalance->amount)
                    {
                        // Update the loan status to 'Not Fully Paid'
                        $this->notFullyPaid($loanId);

                        // Remove this loan record from the Active Table
                        $this->removeFromActive($loanId);

                        // Deletes the loan's late remittance record from the database
                        $this->deleteLateBalance($loanId);
                    }
                    // Else if the remittance isn't sufficient for the late balance, deduct it from   // the late balance
                    else
                    {
                        // Deduct the remittance to the total cumulative late remittance amount
                        $deductFromLate = DB::table('late_remittance_amount')
                                          ->where('loan_id', $loanId)
                                          ->update([
                                            'amount' => ($totalLateBalance->amount - $remittance->amount)
                                          ]);

                        // Update the loan status to 'Late'
                        $this->updateLoanStatus = "Late";
                        $this->changeStatus(3);
                    }

                }   
            } 
            // If the early remittance is less than the deduction, the loan status
            // is changed to 'Late' and the missing remittance is added in the 
            // late remittances amount
            elseif($remittance->amount < get_deduction($loanId)->deduction) 
            {
                // Change the loan status to 'Late'
                $this->updateLoanStatus = "Late";
                $this->changeStatus(3);

                // Add the missing remittance to the late remittance amount in the database
                // Add a new late remittance for the loan
                $add_late_remittance = DB::table('late_remittance_amount')
                                        ->insert([
                                            [
                                                'loan_id' => $loanId,
                                                'amount' => (float)get_deduction($loanId)->deduction - (float)$remittance->amount
                                            ]
                                        ]);
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

        // Get the borrower for the loan
        $getBorrowerId = DB::table('loans')
                        ->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
                        ->where('loans.id', $this->loanId)
                        ->select('borrowers.*')
                        ->first();

        // Store the borrower's name
        $this->remittanceBorrower = $getBorrowerId->name;


        // If the loan is paid or not fully paid, broadcast to the Loan, Loan Master List, and 
        // Borrrower Channels
        if($this->updateLoanStatus == "Paid" || $this->updateLoanStatus == "Not Fully Paid")
        {
            return [
                new PrivateChannel('loanChannel.'.$this->loanId),
                new PrivateChannel('loanMasterListChannel'),
                new PrivateChannel('borrowerChannel.'.$getBorrowerId->id)
            ];
        }
        // If else, broadcast only on the Loan and Borrowers Channel
        else
        {
            return [
                new PrivateChannel('loanChannel.'.$this->loanId),
                new PrivateChannel('borrowerChannel.'.$getBorrowerId->id)
            ];
        }
        

    }
}
