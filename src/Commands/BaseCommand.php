<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\HttpAdapter\Client;
use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Resources\Discord;
use eDiasoft\Midjourney\Resources\Midjourney;

class BaseCommand implements Builder
{
    protected Client $client;
    protected Config $config;
    protected string $prompt;
    protected array $arguments = [];
    protected array $payload;
    protected string $interactionId;
    protected int $type = 2;

    public function __construct(Config $config, string $prompt = '')
    {
        $this->config = $config;

        $this->prompt = $prompt;

        $this->client = new Client($this->config);

        $this->interactionId = uniqid();

        $this->defaultPayload();
    }

    public function defaultPayload()
    {
        $this->payload = array(
            'type'                  => $this->type,
            'application_id'        => Midjourney::APPLICATION_ID,
            'guild_id'              => $this->config->guildId(),
            'channel_id'            => $this->config->channelId(),
            'session_id'            => uniqid(),
            "nonce"                 => $this->interactionId,
            "analytics_location"    => "slash_ui",
            'attachments'           => []
        );

        return $this;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function interactionId()
    {
        return $this->interactionId;
    }

    public function send()
    {
        return $this->client->setHeaders([
            'Content-Type'  => 'application/json'
        ])->post(Discord::INTERACTIONS_URL, json: $this->payload());
    }
}
