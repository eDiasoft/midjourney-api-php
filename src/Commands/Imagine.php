<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\Exceptions\MidjourneyException;
use eDiasoft\Midjourney\Resources\Discord;
use eDiasoft\Midjourney\Resources\Midjourney;

class Imagine extends BaseCommand
{
    private int $maxRetries = 10;
    private int $intervalSeconds = 10;
    protected array $payload;

    public function payload(): array
    {
        $this->payload = array_merge($this->payload, array(
            'data'              => [
                'version'           => Midjourney::IMAGINE_DATA_VERSION,
                'id'                => Midjourney::IMAGINE_DATA_ID,
                'name'              => 'imagine',
                'type'              => 1,
                'options'           => array([
                    "type"      =>  3,
                    "name"      => "prompt",
                    "value"     => $this->prompt. ' [' . $this->interactionId . '] ' . implode(' ', $this->arguments)
                ])
            ],
            "application_command"   =>  [
                "id"                            =>  Midjourney::IMAGINE_DATA_ID,
                "application_id"                =>  Midjourney::APPLICATION_ID,
                "version"                       =>  Midjourney::IMAGINE_DATA_VERSION,
                "default_member_permissions"    =>  null,
                "type"                          =>  1,
                "nsfw"                          =>  false,
                "name"                          =>  "imagine",
                "description"                   =>  "Create images with Midjourney",
                "dm_permission"                 =>  true,
                "contexts"                      =>  [0, 1, 2],
                "options"                       =>  array([
                    "type"              =>  3,
                    "name"              =>  "prompt",
                    "description"       =>  "The prompt to imagine",
                    "required"          =>  true
                ])
            ]
        ));

        return parent::payload();
    }

    public function aspectRatio(string $ratio)
    {
        $this->arguments[] = "--aspect " . $ratio;

        return $this;
    }

    public function chaos(int $number)
    {
        $this->arguments[] = "--chaos " . $number;

        return $this;
    }

    public function fast()
    {
        $this->arguments[] = "--fast";

        $this->intervalSeconds = 30;

        return $this;
    }

    public function imageWeight(int $weight)
    {
        $this->arguments[] = "--iw " . $weight;

        return $this;
    }

    public function no(string $exclude)
    {
        $this->arguments[] = "--no " . $exclude;

        return $this;
    }

    public function quality(float $number)
    {
        $this->arguments[] = "--quality " . $number;

        return $this;
    }

    public function relax()
    {
        $this->arguments[] = "--relax";

        $this->intervalSeconds = 60;

        return $this;
    }

    public function repeat(int $times)
    {
        $this->arguments[] = "--repeat " . $times;

        return $this;
    }

    public function seed(int $number)
    {
        $this->arguments[] = "--seed " . $number;

        return $this;
    }

    public function stop(int $number)
    {
        $this->arguments[] = "--stop " . $number;

        return $this;
    }

    public function style(string $style)
    {
        $this->arguments[] = "--style " . $style;

        return $this;
    }

    public function stylize(int $number)
    {
        $this->arguments[] = "--stylize " . $number;

        return $this;
    }

    public function tile()
    {
        $this->arguments[] = "--tile";

        return $this;
    }

    public function turbo()
    {
        $this->arguments[] = "--turbo";

        $this->intervalSeconds = 15;

        return $this;
    }

    public function weird(int $number)
    {
        $this->arguments[] = "--weird " . $number;

        return $this;
    }

    public function setMaxRetries(int $maxRetries)
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    public function send()
    {
        parent::send();

        return $this->retrieveGeneratedImage();
    }

    public function prompt()
    {
        return $this->prompt. ' ' . implode(' ', $this->arguments);
    }

    private function retrieveGeneratedImage($tries = 0)
    {
        if($tries <= $this->maxRetries)
        {
            sleep($this->intervalSeconds);

            $response = $this->client->get(Discord::CHANNELS_URL . '/' . $this->config->channelId() . '/messages');
            $re = '/(.*)(\[(.*)\])(.*)/m';

            foreach($response->body() as $message)
            {
                preg_match($re, $message['content'], $matches);

                if(isset($matches[3]) && $matches[3] == $this->interactionId && !empty($message['attachments']) && !str_contains($message['attachments'][0]['filename'], 'grid'))
                {
                    return $message;
                }
            }

            return $this->retrieveGeneratedImage($tries + 1);
        }

        throw new MidjourneyException('Max tries exceeded, increase the max try attempt ($midjourney->imagine(*)->setMaxRetries(30)) or check your discord what went wrong.');
    }
}
