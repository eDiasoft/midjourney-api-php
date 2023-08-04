<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\HttpAdapter\Client;
use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Resources\Discord;
use eDiasoft\Midjourney\Resources\Midjourney;

class BaseCommand implements Builder
{
    protected Config $config;
    protected string $prompt;
    protected array $arguments = [];
    protected array $payload;
    protected string $interactionId;

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
            'type'              => 2,
            'application_id'    => Midjourney::APPLICATION_ID,
            'guild_id'          => $this->config->guildId(),
            'channel_id'        => $this->config->channelId(),
            'session_id'        => uniqid(),
            'attachments'       => []
        );

        return $this;
    }

    public function payload(): string
    {
        return json_encode($this->payload);
    }

    public function send()
    {
        return $this->client->setHeaders([
            'Content-Type'  => 'application/x-www-form-urlencoded'
        ])->post(Discord::INTERACTIONS_URL, [
            'payload_json'      => $this->payload()
        ]);
    }
}
