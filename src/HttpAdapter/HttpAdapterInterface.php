<?php

namespace eDiasoft\Midjourney\HttpAdapter;

use eDiasoft\Midjourney\Response\DefaultResponse;

interface HttpAdapterInterface
{
    public function send(string $httpMethod, string $url, array $headers = [], array $queries = [], string $httpBody = null, string $responseClass = DefaultResponse::class);
}
