<?php

namespace App\Jobs;

use App\Events\NewFibaAgentListAvailable;
use App\Events\NewFibaAgentUrl;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class FetchFibaAgents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const FIBA_AGENTS_URL = 'http://www.fiba.basketball/find-basketball-agent';

    public function handle(): void
    {
        Log::info('FetchFibaAgents job started');

        $html = $this->fetchHtml();

        $fibaAgentsUrls = $this->getFibaAgentsUrls($html);

        foreach ($fibaAgentsUrls as $fibaAgentUrl) {
            NewFibaAgentUrl::dispatch(strval($fibaAgentUrl));
        }

        NewFibaAgentListAvailable::dispatch($fibaAgentsUrls->all());
    }

    private function getFibaAgentsUrls(string $html): Collection
    {
        $token = $this->getToken($html);
        $agentsIds = $this->getFibaAgentsIds($html);

        return $agentsIds->map(fn (string $id) => $this->buildAgentUrl($id, $token));
    }

    private function getToken(string $html): string
    {
        $tokenRegex = '/<form class="search_filters_form custom" action="\/en\/Module\/([a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12})">/';
        preg_match($tokenRegex, $html, $matches);
        if (empty($matches[1])) {
            throw new Exception('Failed to find token!');
        }

        return $matches[1];
    }

    private function getFibaAgentsIds(string $body): Collection
    {
        $agentsIdsRegex = '/<option value="(\d*)">(.*?), (.*?)\((.*?)\)<\/option>/';
        preg_match_all($agentsIdsRegex, $body, $matches);
        $agentsIds = $matches[1];
        if (empty($agentsIds)) {
            throw new Exception('Failed to find agents ids!');
        }

        return collect($agentsIds);
    }

    private function buildAgentUrl(string $id, string $token): string
    {
        return "http://www.fiba.basketball/en/Module/$token?type=item&PersonId=$id";
    }

    private function fetchHtml(): string
    {
        $response = Http::get(self::FIBA_AGENTS_URL);
        if (! $response->ok()) {
            throw new Exception('Failed to fetch url!');
        }

        return $response->body();
    }
}
