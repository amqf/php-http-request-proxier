<?php

namespace AMQF\HttpRequestProxier;

use DOMDocument;
use DOMXPath;

/**
 * Broken Class
 * I'm implementing it...
 */
class UserAgentListUpdater
{
    private string $url = 'https://deviceatlas.com/blog/list-of-user-agent-strings';

    public function __construct(
        private string $_filePath,
        private UserAgentRepository $_userAgentRepository
    )
    {
    }

    private function downloadPage(): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36');
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    private function parseUserAgents(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $rows = $xpath->query('//table[@class="table table-striped"]//tbody/tr');
        $userAgents = [];

        $deviceName = '';
        foreach ($rows as $row) {
            if ($row->nodeName === 'th') {
                $deviceName = trim($xpath->query('./text()', $row)->item(0)->nodeValue);
            } elseif ($row->nodeName === 'td') {
                $userAgent = trim($xpath->query('./text()', $row)->item(0)->nodeValue);
                if ($deviceName && $userAgent) {
                    $userAgents[] = [$deviceName, $userAgent];
                }
            }
        }

        return $userAgents;
    }

    public function update(): void
    {
        $html = $this->downloadPage();
        $userAgents = $this->parseUserAgents($html);
        $this->_userAgentRepository->update($this->_filePath, $userAgents);
    }
}