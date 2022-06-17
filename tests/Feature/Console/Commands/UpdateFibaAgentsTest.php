<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UpdateFibaAgentsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'http://www.fiba.basketball/find-basketball-agent' => Http::response(
                file_get_contents(__DIR__.'/../../../Fixtures/fiba-agents-2022-06-17.html')
            ),
        ]);
    }

    public function test_should_work_correctly(): void
    {
        $this->artisan('fiba-agents')->assertExitCode(Command::SUCCESS);
    }
}
