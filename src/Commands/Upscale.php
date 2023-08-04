<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\Config\Config;
use eDiasoft\Midjourney\Exceptions\MidjourneyException;
use eDiasoft\Midjourney\Resources\Discord;

class Upscale extends BaseCommand
{
    protected string $messageId;
    protected string $customId;
    protected int $type = 3;
    private int $maxRetries = 10;
    private int $intervalSeconds = 10;

    public function __construct(Config $config, string $messageId, string $interactionId, string $customId)
    {
        parent::__construct($config);

        $this->messageId = $messageId;
        $this->customId = $customId;
        $this->interactionId = $interactionId;
    }

    public function payload(): array
    {
        $this->payload = array_merge($this->payload, array(
            'message_id'        => $this->messageId,
            'data'              => [
                'component_type'    => 2,
                'custom_id'         => $this->customId
            ]
        ));

        return parent::payload();
    }

    public function send()
    {
        parent::send();

        preg_match('/MJ::JOB::upsample::([0-9])::(.*)/', $this->customId, $matches);

        if(isset($matches[1]) && is_numeric($matches[1]))
        {
            return $this->retrieveGeneratedImage($matches[1]);
        }

        throw new MidjourneyException("Can't find the number of image you want to upscale.");
    }

    private function retrieveGeneratedImage(int $imageNumber, $tries = 0)
    {
        if($tries <= $this->maxRetries)
        {
            sleep($this->intervalSeconds);

            $response = $this->client->get(Discord::CHANNELS_URL . '/' . $this->config->channelId() . '/messages');
            $re = '/\*\*(.*)\[' . $this->interactionId . '\](.*)\*\*(.*)(Image #' . $imageNumber . ')(.*)/';

            foreach($response->body() as $message)
            {
                if(
                    $message['type'] == 19 &&
                    count($message['attachments']) &&
                    !str_contains($message['attachments'][0]['filename'], 'grid') &&
                    count(preg_grep($re, [$message['content']]))
                )
                {
                    return $message;
                }
            }

            return $this->retrieveGeneratedImage($imageNumber, $tries + 1);
        }

        throw new MidjourneyException('Max tries exceeded, check your discord what went wrong.');
    }
}


