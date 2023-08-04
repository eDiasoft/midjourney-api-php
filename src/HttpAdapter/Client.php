<?php

namespace eDiasoft\Midjourney\HttpAdapter;

use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Resources\Http;
use eDiasoft\Midjourney\Response\Transaction;

class Client
{
    private HttpAdapterInterface $httpClient;
    private array $headers;

    public function __construct(Config $config)
    {
        $this->httpClient = (new HttpAdapterPicker())->pickHttpAdapter();

        $this->headers = array(
            'Authorization' => $config->authToken(),
        );
    }

    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function get($url, $queries = array())
    {
        return $this->httpClient->send(Http::GET, $url, $this->headers, $queries);
    }

    public function post($url, $body = [])
    {
        return $this->httpClient->send(Http::POST, $url, $this->headers, form_params: $body);
    }
}
