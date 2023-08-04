<?php

namespace eDiasoft\Midjourney\Resources;

class Discord
{
    public const BASE_URL = "https://discord.com/api/v10";
    public const CHANNELS_URL = self::BASE_URL . "/channels";

    public const WEBHOOK_URL = self::BASE_URL . "/webhooks";
    public const INTERACTIONS_URL = self::BASE_URL . "/interactions";
}
