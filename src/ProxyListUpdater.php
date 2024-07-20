<?php

namespace AMQF\HttpRequestProxier;

use DOMDocument;
use DOMXPath;

class ProxyListUpdater
{
    private string $_url = 'https://free-proxy-list.net/';

    public function __construct(
        private string $_filePath,
        private ProxyRepository $_proxyRepository
    )
    {
    }

    private function downloadPage() : string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    private function parseProxiesList($html) : array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $nodes = $xpath->query('//table[@class="table table-striped table-bordered"]//tbody/tr');
        $proxies = [];

        foreach ($nodes as $node) {
            $ip = trim($xpath->query('./td[1]', $node)->item(0)->nodeValue);
            $port = trim($xpath->query('./td[2]', $node)->item(0)->nodeValue);
            if ($ip && $port) {
                $proxies[] = "$ip:$port";
            }
        }

        return $proxies;
    }

    public function update() : void
    {
        $html = $this->downloadPage();
        $proxies = $this->parseProxiesList($html);
        $this->_proxyRepository->update($this->_filePath, $proxies);
    }
}
