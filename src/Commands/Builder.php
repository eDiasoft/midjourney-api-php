<?php

namespace eDiasoft\Midjourney\Commands;

interface Builder
{
    public function payload(): string;
    public function send();
}
