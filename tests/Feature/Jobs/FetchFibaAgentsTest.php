<?php

namespace Tests\Feature\Jobs;

use App\Events\NewFibaAgentListAvailable;
use App\Events\NewFibaAgentUrl;
use App\Jobs\FetchFibaAgents;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FetchFibaAgentsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    public function test_should_work_correctly()
    {
        Log::shouldReceive('info')->withAnyArgs()->once();

        Http::fake([
            'http://www.fiba.basketball/find-basketball-agent' => Http::response(
                file_get_contents(__DIR__.'/../../Fixtures/fiba-agents-2022-06-17.html')
            ),
        ]);

        $job = new FetchFibaAgents();
        $job->handle();

        Event::assertDispatchedTimes(NewFibaAgentUrl::class, 607);
        Event::assertDispatchedTimes(NewFibaAgentListAvailable::class, 1);
    }
}
