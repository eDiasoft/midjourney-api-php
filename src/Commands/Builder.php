<?php

namespace eDiasoft\Midjourney\Commands;

interface Builder
{
    public function defaultPayload();
    public function payload(): string;

    public function send();
}
