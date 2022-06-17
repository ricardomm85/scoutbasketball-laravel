<?php

namespace App\Console\Commands;

use App\Jobs\FetchFibaAgents;
use Illuminate\Console\Command;

class FibaAgents extends Command
{
    /**
     * @var string
     */
    protected $signature = 'fiba-agents';

    /**
     * @var string
     */
    protected $description = 'Crawl Fiba agents website and update database';

    public function handle(): int
    {
        $this->info('Fiba agent command started');

        FetchFibaAgents::dispatch();

        return Command::SUCCESS;
    }
}
