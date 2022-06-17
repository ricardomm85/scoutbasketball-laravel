<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class NewFibaAgentListAvailable
{
    use Dispatchable;

    public function __construct(
        public readonly array $fibaAgentsUrls,
    ) {
    }
}
