<?php

namespace eDiasoft\Midjourney;


use eDiasoft\Midjourney\Commands\Imagine;
use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Config\DefaultConfig;

class MidjourneyApiClient
{
    private Config $config;
    public function __construct(int $channel_id, string $authToken, string $guild_id = null)
    {
        $this->config = new DefaultConfig($channel_id, $authToken, $guild_id);
    }

    public function imagine($prompt)
    {
        return new Imagine($this->config, $prompt);
    }
}
