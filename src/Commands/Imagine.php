<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\Resources\Midjourney;

class Imagine extends BaseCommand
{
    protected array $payload;

    public function defaultPayload()
    {
        $this->payload = array(
            'type'              => 2,
            'application_id'    => Midjourney::APPLICATION_ID,
            'guild_id'          => $this->config->guildId(),
            'channel_id'        => $this->config->channelId(),
            'session_id'        => uniqid(),
            'data'              => [
                'version'           => '1118961510123847772',
                'id'                => '938956540159881230',
                'name'              => 'imagine',
                'type'              => 1,
                'options'           => array([
                    "type"      =>  3,
                    "name"      => "prompt",
                    "value"     => $this->prompt
                ])
            ],
            "application_command"   =>  [
                "id"                            =>  "938956540159881230",
                "application_id"                =>  Midjourney::APPLICATION_ID,
                "version"                       =>  "1118961510123847772",
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
            ],
            'attachments'       => []
        );

        return $this;
    }
}
