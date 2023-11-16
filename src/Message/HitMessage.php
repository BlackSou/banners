<?php

namespace App\Message;

class HitMessage
{
    private $ip;
    private $useragent;
    private $identifier;

    public function __construct(string $ip, string $useragent, string $identifier)
    {
        $this->ip = $ip;
        $this->useragent = $useragent;
        $this->identifier = $identifier;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getUserAgent(): string
    {
        return $this->useragent;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
