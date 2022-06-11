<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateFibaAgents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:update-fiba-agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Fiba agents website and update database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Crawling Fiba agents website...');

        return Command::SUCCESS;
    }
}
