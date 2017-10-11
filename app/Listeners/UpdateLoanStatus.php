<?php

namespace App\Listeners;

use App\Events\Remittance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateLoanStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Remittance  $event
     * @return void
     */
    public function handle(Remittance $event)
    {
        
    }
}
