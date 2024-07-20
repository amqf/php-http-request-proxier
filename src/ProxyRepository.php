<?php

namespace AMQF\HttpRequestProxier;

class ProxyRepository
{
    private array $_proxies = [];

    public function __construct(private string $_filePath)
    {
        $this->_filePath = $_filePath;
        $this->loadProxies();
    }

    private function loadProxies() : void
    {
        if (file_exists($this->_filePath)) {
            $lines = file($this->_filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $this->_proxies[] = new ProxyAttributes($line);
            }
        }
    }

    public function getProxies($_limit = 0) : array
    {
        if ($_limit > 0) {
            return array_slice($this->_proxies, 0, $_limit);
        }
        return $this->_proxies;
    }

    public function update(string $filePath, array $proxies) : void
    {
        if (!file_exists($filePath))
        {
            file_put_contents($filePath, NULL);
        }
        
        file_put_contents($filePath, implode(PHP_EOL, $proxies));
    }
}
