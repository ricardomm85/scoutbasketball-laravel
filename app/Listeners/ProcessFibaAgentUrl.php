<?php

namespace App\Listeners;

use App\Events\NewFibaAgentUrl;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ProcessFibaAgentUrl implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(NewFibaAgentUrl $event): void
    {
        Log::info('ProcessFibaAgent job started: '.$event->url);
        // @TODO
    }
}
