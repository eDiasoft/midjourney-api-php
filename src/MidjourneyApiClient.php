<?php

namespace eDiasoft\Midjourney;


use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Config\DefaultConfig;

class MidjourneyApiClient
{
    private Config $config;
    public function __construct(string $customerID, ?string $secret = null, ?array $config = [])
    {
        $this->config = new DefaultConfig($customerID, $secret, $config);
    }

}
