<?php
namespace eDiasoft\Midjourney\Config;

use eDiasoft\Gomypay\Exceptions\GomypayException;

abstract class Config
{
    private int $channelId;
    private string $authToken;

    public function __construct(int $channel_id, string $authToken)
    {
        $this->channelId = $channel_id;
        $this->authToken = $authToken;
    }
}
