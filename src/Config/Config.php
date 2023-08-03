<?php
namespace eDiasoft\Midjourney\Config;

use eDiasoft\Exceptions\Exceptions\MidjourneyException;
use eDiasoft\Midjourney\HttpAdapter\Client;
use eDiasoft\Midjourney\Resources\Discord;

abstract class Config
{
    private int $channelId;
    private string $authToken;
    private ?string $guildId;
    private Client $client;

    public function __construct(int $channel_id, string $authToken, string $guild_id = null)
    {
        $this->channelId = $channel_id;
        $this->authToken = $authToken;
        $this->guildId = $guild_id;

        $this->client = new Client($this);

    }

    public function channelId()
    {
        return $this->channelId;
    }

    public function authToken()
    {
        return $this->authToken;
    }

    public function guildId()
    {
        if(!$this->guildId)
        {
            $channel_response = $this->client->get(Discord::CHANNELS_URL . '/' . $this->channelId);

            if(!isset($channel_response->body()['guild_id']))
            {
                throw new MidjourneyException('Can\'t retrieve Guild ID.');
            }

            $this->guildId = $channel_response->body()['guild_id'];
        }

        return $this->guildId;
    }
}
