<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class NewFibaAgentUrl
{
    use Dispatchable;

    public function __construct(
        public readonly string $url,
    ) {
    }
}
