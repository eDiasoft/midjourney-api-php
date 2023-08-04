<?php

namespace eDiasoft\Midjourney\Commands;

interface Builder
{
    public function payload(): array;
    public function send();
}
