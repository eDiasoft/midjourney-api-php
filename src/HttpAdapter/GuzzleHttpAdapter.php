<?php

namespace eDiasoft\Midjourney\HttpAdapter;

use Composer\CaBundle\CaBundle;
use eDiasoft\Midjourney\Exceptions\ApiException;
use eDiasoft\Midjourney\Response\DefaultResponse;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpAdapter implements HttpAdapterInterface
{
    public const DEFAULT_TIMEOUT = 10;
    public const DEFAULT_CONNECT_TIMEOUT = 2;
    public const HTTP_NO_CONTENT = 204;

    protected ClientInterface $httpClient;
    private string $response;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function send(string $httpMethod, string $url, array $headers = [], array $queries = [], ?array $form_params = null, ?array $json = null, string $responseClass = DefaultResponse::class)
    {
        $request = new Request($httpMethod, $url, $headers);

        $this->response = $responseClass;

        try {
            $response = $this->httpClient->send($request, [
                'http_errors'           => false,
                'query'                 => $queries,
                'form_params'           => $form_params,
                'json'                  => $json
            ]);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }

        return $this->parseResponseBody($response);
    }

    private function parseResponseBody(ResponseInterface $response)
    {
        $body = (string) $response->getBody();

        if (empty($body))
        {
            if ($response->getStatusCode() === self::HTTP_NO_CONTENT)
            {
                return null;
            }

            throw new ApiException("No response body found.");
        }

        $object = @json_decode($body, true);

        if(isset($object->data->error))
        {
            throw new ApiException($object->data->error);
        }

        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new ApiException("Unable to decode Midjourney response: '{$body}'.");
        }

        return new $this->response($object);
    }

    public static function createDefault()
    {
        $retryMiddlewareFactory = new GuzzleRetryMiddlewareFactory;
        $handlerStack = HandlerStack::create();
        $handlerStack->push($retryMiddlewareFactory->retry());

        $client = new Client([
            GuzzleRequestOptions::VERIFY => CaBundle::getBundledCaBundlePath(),
            GuzzleRequestOptions::TIMEOUT => self::DEFAULT_TIMEOUT,
            GuzzleRequestOptions::CONNECT_TIMEOUT => self::DEFAULT_CONNECT_TIMEOUT,
            'handler' => $handlerStack,
        ]);

        return new GuzzleHttpAdapter($client);
    }
}
