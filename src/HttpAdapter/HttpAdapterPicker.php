<?php

namespace eDiasoft\Midjourney\HttpAdapter;

use eDiasoft\Midjourney\Exceptions\UnrecognizedHttpClientException;

class HttpAdapterPicker
{
    public function pickHttpAdapter($httpClient = null)
    {
        if(!$httpClient)
        {
            if ($this->guzzleIsDetected())
            {
                $guzzleVersion = $this->guzzleMajorVersionNumber();

                if ($guzzleVersion && in_array($guzzleVersion, [6, 7]))
                {
                    return GuzzleHttpAdapter::createDefault();
                }
            }

            return new CurlHttpAdapter;
        }

        if($httpClient instanceof HttpAdapterInterface)
        {
            return $httpClient;
        }

        if ($httpClient instanceof \GuzzleHttp\ClientInterface)
        {
            return new GuzzleHttpAdapter($httpClient);
        }

        throw new UnrecognizedHttpClientException('The provided http client or adapter was not recognized.');
    }

    private function guzzleIsDetected()
    {
        return interface_exists('\\' . \GuzzleHttp\ClientInterface::class);
    }

    /**
     * @return int|null
     */
    private function guzzleMajorVersionNumber()
    {
        // Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::MAJOR_VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::MAJOR_VERSION;
        }

        // Before Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::VERSION[0];
        }

        return null;
    }
}
