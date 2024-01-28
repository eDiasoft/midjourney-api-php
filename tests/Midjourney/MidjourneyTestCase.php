<?php

namespace Tests\Midjourney;

use eDiasoft\Midjourney\MidjourneyApiClient;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class MidjourneyTestCase extends TestCase
{
    protected MidjourneyApiClient $midjourney;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(getcwd());
        $dotenv->load();

        $this->midjourney = new MidjourneyApiClient($_ENV['DISCORD_MIDJOURNEY_CHANNEL_ID'], $_ENV['DISCORD_AUTH_TOKEN']);

        parent::__construct();
    }
}