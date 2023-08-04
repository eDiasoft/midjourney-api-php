<?php

namespace eDiasoft\Midjourney\Commands;

use eDiasoft\Midjourney\Resources\Midjourney;

class Info extends BaseCommand
{
    public function defaultPayload()
    {
        $this->payload = array(
            'token'             => 'shuid',
            'data'              => [
                'version'           => Midjourney::INFO_DATA_VERSION,
                'id'                => Midjourney::INFO_DATA_ID,
                'name'              => 'info',
                'type'              => 1,
                'options'           => array(),
                'application_command'   =>  [
                    'id'                            =>  Midjourney::INFO_DATA_ID,
                    'application_id'                =>  Midjourney::APPLICATION_ID,
                    'version'                       =>  Midjourney::INFO_DATA_VERSION,
                    'default_member_permissions'    =>  null,
                    'type'                          =>  1,
                    'nsfw'                          =>  false,
                    'name'                          =>  'info',
                    'description'                   =>  'View information about your profile.',
                    'dm_permission'                 =>  true,
                    'contexts'                      =>  [0, 1, 2]
                ]
            ]
        );

        return parent::defaultPayload();
    }
}
