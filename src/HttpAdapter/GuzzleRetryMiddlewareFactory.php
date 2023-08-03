<?php

namespace eDiasoft\Midjourney\HttpAdapter;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class GuzzleRetryMiddlewareFactory
{
    public const MAX_RETRIES = 5;
    public const DELAY_INCREASE_MS = 1000;

    public function retry($delay = true)
    {
        return Middleware::retry($this->newRetryDecider(), $delay ? $this->getRetryDelay() : $this->getZeroRetryDelay());
    }

    private function getRetryDelay()
    {
        return function ($numberOfRetries) {
            return static::DELAY_INCREASE_MS * $numberOfRetries;
        };
    }

    private function getZeroRetryDelay()
    {
        return function ($numberOfRetries) {
            return 0;
        };
    }

    private function newRetryDecider()
    {
        return function ($retries, Request $request, Response $response = null, TransferException $exception = null) {
            if ($retries >= static::MAX_RETRIES)
            {
                return false;
            }

            if ($exception instanceof ConnectException)
            {
                return true;
            }

            return false;
        };
    }
}
