<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\HttpAdapter\HttpAdapterInterface;
use eDiasoft\Midjourney\HttpAdapter\HttpAdapterPicker;
use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Resources\Discord;
use eDiasoft\Midjourney\Resources\Http;
use eDiasoft\Midjourney\Response\Transaction;

class BaseCommand implements Builder
{
    protected Config $config;

    private HttpAdapterInterface $httpClient;

    protected array $payload;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->httpClient = (new HttpAdapterPicker())->pickHttpAdapter();

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
        $response = $this->httpClient->send(
            Http::POST, Discord::INTERACTIONS_URL,
            [
                'Authorization' => 'MzkyNDQ3NDEzNTIyMDA2MDE3.GZd1kb._d6zV5OHwMsz7AsZi6ERHAf8FjdoDFfaR9NrlE',
                'Content-Type'  => 'application/x-www-form-urlencoded'
            ],
            [],
            [
                'payload_json'      => $this->payload()
            ],
            responseClass: Transaction::class
        );


        dd($response);
    }
}
