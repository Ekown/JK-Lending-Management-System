<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddLoanRecord implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $borrowerId;

    public function __construct($id)
    {
        $this->borrowerId = $id;

        $loan = (new LoanController)->getLoanDetails($id)->first();

        $remittanceDateArray = (new RemittanceController)->getDates();

        foreach ($remittanceDateArray as $date) 
        {
            if($loan->remittance_date_id == $date->id) 
            {
                $finalRemittanceDateArray = explode('/', $date->remittance_date);
            }
        }

        $dueDate = getDueDate(Carbon::now()->day, $loan->term, $finalRemittanceDateArray, $loan->term_type_id);
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
