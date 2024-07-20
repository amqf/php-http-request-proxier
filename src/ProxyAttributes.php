<?php

namespace AMQF\HttpRequestProxier;

class ProxyAttributes
{
    private string $host;
    private string $port;

    public function __construct($line)
    {
        list($this->host, $this->port) = explode(':', trim($line));
    }

    public function getHost() : string
    {
        return $this->host;
    }

    public function getPort() : string
    {
        return $this->port;
    }

    public function __toString() : string
    {
        return sprintf("%s:%s", $this->host, $this->port);
    }
}
