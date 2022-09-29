<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\resetTimer;

class listenResetTimer
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(resetTimer $leagueId)
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
