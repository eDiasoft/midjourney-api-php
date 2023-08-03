<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\HttpAdapter\Client;
use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Resources\Discord;

class BaseCommand implements Builder
{
    protected Config $config;
    protected string $prompt;
    protected array $payload;

    public function __construct(Config $config, string $prompt = '')
    {
        $this->config = $config;

        $this->prompt = $prompt;

        $this->client = new Client($this->config);

        $this->defaultPayload();
    }

    public function defaultPayload()
    {
        $this->payload = array();

        return $this;
    }

    public function payload(): string
    {
        return json_encode($this->payload);
    }

    public function send()
    {
        $this->client->setHeaders([
            'Content-Type'  => 'application/x-www-form-urlencoded'
        ])->post(Discord::INTERACTIONS_URL, [
            'payload_json'      => $this->payload()
        ]);
    }
}
