<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\Resources\Midjourney;

class Imagine extends BaseCommand
{
    protected array $payload;

    public function payload(): string
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

        return $this;
    }

    public function weird(int $number)
    {
        $this->arguments[] = "--weird " . $number;

        return $this;
    }

    public function send()
    {
        parent::send();
    }
}
