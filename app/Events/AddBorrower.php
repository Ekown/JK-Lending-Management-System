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

class AddBorrower implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $borrower;

    public function __construct($borrowerId)
    {
        // Store the borrower's instance using the injected borrower id
        $this->borrower = DB::table('borrowers')
                ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                ->where('borrowers.id', $borrowerId)
                ->select('borrowers.name as name', 'companies.name as company', 'companies.id as company_id')
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
            new PrivateChannel('borrowerMasterListChannel'),
            new PrivateChannel('companyChannel.'.$this->borrower->first()->company_id )
        ];
    }
}
