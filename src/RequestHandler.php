<?php

namespace AMQF\HttpRequestProxier;

class RequestHandler
{
    public function execute(RequestParams $params, ?ProxyAttributes $proxyAttributes = null) : void
    {
        echo __CLASS__ . ": Requesting... \n";
        echo __CLASS__ . ": With params $params\n";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $params->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($params->getMethod() === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($params->getPostFields()) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params->getPostFields());
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $params->getHeaders());

        if($proxyAttributes instanceof ProxyAttributes)
        {
            sprintf("\tProxy %s:%s...\n", $proxyAttributes->getHost(), $proxyAttributes->getPort());
            curl_setopt($ch, CURLOPT_PROXY, $proxyAttributes->getHost());
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxyAttributes->getPort());
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo __CLASS__ . ': Error '. curl_error($ch) . PHP_EOL;

        } else {
            echo __CLASS__ . ": Response [ $response ]\n";
        }

        curl_close($ch);
    }
}
