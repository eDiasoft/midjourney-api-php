<?php
namespace eDiasoft\Midjourney\Config;

use eDiasoft\Gomypay\Exceptions\GomypayException;

abstract class Config
{
    private string $customerId;
    private ?string $secretKey;
    private bool $test = false;
    private ?string $store_id = null;
    private string $returnUrl;
    private string $callbackUrl;

    public function __construct(string $customerId, ?string $secretKey = null, ?array $config = [])
    {
        $this->customerId = $customerId;
        $this->secretKey = $secretKey;

        $this->setConfigValues($config);
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property))
        {
            $this->$property = $value;
        }

        return $this;
    }

    protected function setConfigValues(array $config = [])
    {
        foreach($config as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public function isLiveMode(): bool
    {
        return !$this->test;
    }

    public function customerId(): string
    {
        return $this->customerId;
    }

    public function secretKey(): string
    {
        if(!$this->secretKey)
        {
            throw new GomypayException('Secret key is missing.');
        }

        return $this->secretKey;
    }

    public function storeId()
    {
        return $this->store_id;
    }

    public function returnUrl(): ?string
    {
        return $this->returnUrl ?? null;
    }

    public function callbackUrl(): ?string
    {
        return $this->callbackUrl ?? null;
    }
}
