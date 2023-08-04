<?php

namespace eDiasoft\Midjourney\HttpAdapter;

use Composer\CaBundle\CaBundle;

use eDiasoft\Midjourney\Response\DefaultResponse;
use eDiasoft\Midjourney\Resources\Http;
use eDiasoft\Midjourney\Exceptions\ApiException;
use eDiasoft\Midjourney\Exceptions\CurlConnectTimeoutException;

final class CurlHttpAdapter implements HttpAdapterInterface
{
    public const DEFAULT_TIMEOUT = 10;
    public const DEFAULT_CONNECT_TIMEOUT = 2;
    public const HTTP_NO_CONTENT = 204;
    public const MAX_RETRIES = 5;
    public const DELAY_INCREASE_MS = 1000;
    private string $response;

    public function send(string $httpMethod, string $url, array $headers = [], array $queries = [], ?array $form_params = null, ?array $json = null, string $responseClass = DefaultResponse::class)
    {
        $this->response = $responseClass;

        for ($i = 0; $i <= self::MAX_RETRIES; $i++)
        {
            usleep($i * self::DELAY_INCREASE_MS);

            try {
                return $this->attemptRequest($httpMethod, $url, $headers, $queries);
            } catch (CurlConnectTimeoutException $e) {
                //
            }
        }

        throw new CurlConnectTimeoutException("Unable to connect to Midjourney. Maximum number of retries (". self::MAX_RETRIES .") reached.");
    }

    protected function attemptRequest($httpMethod, $url, $headers, $queries)
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->parseHeaders($headers));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::DEFAULT_CONNECT_TIMEOUT);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::DEFAULT_TIMEOUT);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_CAINFO, CaBundle::getBundledCaBundlePath());

        switch ($httpMethod) {
            case HTTP::GET:
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
            case HTTP::POST:
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $queries);
                break;
            case HTTP::PATCH:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $queries);
                break;
            case HTTP::DELETE:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $queries);

                break;
            default:
                throw new \InvalidArgumentException("Invalid http method: ". $httpMethod);
        }

        $startTime = microtime(true);
        $response = curl_exec($curl);
        $endTime = microtime(true);

        if ($response === false)
        {
            $executionTime = $endTime - $startTime;
            $curlErrorNumber = curl_errno($curl);
            $curlErrorMessage = "Curl error: " . curl_error($curl);

            if ($this->isConnectTimeoutError($curlErrorNumber, $executionTime))
            {
                throw new CurlConnectTimeoutException("Unable to connect to Midjourney. " . $curlErrorMessage);
            }

            throw new ApiException($curlErrorMessage);
        }

        $statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        return $this->parseResponseBody($response, $statusCode, $queries);
    }

    protected function parseResponseBody($response, $statusCode, $queries)
    {
        if (empty($response))
        {
            if ($statusCode === self::HTTP_NO_CONTENT)
            {
                return null;
            }

            throw new ApiException("No response body found.");
        }

        $body = @json_decode($response, true);

        // GUARDS
        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new ApiException("Unable to decode Midjourney response: '{$response}'.");
        }

        if (isset($body->error))
        {
            throw new ApiException($body->error->message);
        }

        if ($statusCode >= 400)
        {
            $message = "Error executing API call ({$body->status}: {$body->title}): {$body->detail}";

            $field = null;

            if (! empty($body->field))
            {
                $field = $body->field;
            }

            if (isset($body->_links, $body->_links->documentation))
            {
                $message .= ". Documentation: {$body->_links->documentation->href}";
            }

            if ($queries)
            {
                $message .= ". Request body: {$queries}";
            }

            throw new ApiException($message, $statusCode, $field);
        }

        return new $this->response($body);
    }

    protected function parseHeaders($headers)
    {
        $result = [];

        foreach ($headers as $key => $value)
        {
            $result[] = $key .': ' . $value;
        }

        return $result;
    }
}
