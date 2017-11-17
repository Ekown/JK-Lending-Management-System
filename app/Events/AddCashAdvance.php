<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AddCashAdvance implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cashAdvance;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cashAdvanceId)
    {
        $this->cashAdvance = DB::table('cash_advances')
                                ->leftJoin('cash_advance_amount', 'cash_advances.cash_advance_amount_id', '=', 'cash_advance_amount.id')
                                ->where('cash_advances.id', $cashAdvanceId)
                                ->select('cash_advances.loan_id as loan_id', 'cash_advances.id as id', 'cash_advance_amount.amount as amount')
                                ->get();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('cashAdvanceMasterListChannel'),
            new PrivateChannel('loanChannel.'.$this->cashAdvance->first()->loan_id)
        ];
    }
}
