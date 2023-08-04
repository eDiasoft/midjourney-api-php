<?php

namespace eDiasoft\Midjourney\Commands;

class Upscale extends BaseCommand
{
    public function defaultPayload()
    {
        $this->payload = array(
            'data'              => [
                'component_type'    => 2,
                'custom_id'         => 'MJ::JOB::upsample::1::92b5cdcb-1a2d-46d2-b3f2-82ecc8323153'
            ]
        );

        return parent::defaultPayload();
    }
}


