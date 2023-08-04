<?php

namespace eDiasoft\Midjourney\HttpAdapter;

use eDiasoft\Midjourney\Response\DefaultResponse;

interface HttpAdapterInterface
{
    public function send(string $httpMethod, string $url, array $headers = [], array $queries = [], ?array $form_params = null, ?array $json = null, string $responseClass = DefaultResponse::class);
}
