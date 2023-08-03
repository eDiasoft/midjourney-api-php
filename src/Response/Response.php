<?php

namespace eDiasoft\Midjourney\Response;

abstract class Response
{
    protected array $body;

    public function __construct(array $body)
    {
        $this->body = $body;

        foreach($body as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property))
        {
            $this->$property = $value;
        }

        return $this;
    }

    public function body()
    {
        return $this->body;
    }
}
