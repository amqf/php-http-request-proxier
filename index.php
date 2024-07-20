<?php

require_once './vendor/autoload.php';

use AMQF\HttpRequestProxier\ProxyListUpdater;
use AMQF\HttpRequestProxier\ProxyRepository;
use AMQF\HttpRequestProxier\ProxyServer;
use AMQF\HttpRequestProxier\RequestHandler;
use AMQF\HttpRequestProxier\RequestParams;

const PROXY_LIST_CSV = './proxy.csv';
const USER_AGENT_LIST_CSV = './user_agent.txt';

$proxyRepository = new ProxyRepository(PROXY_LIST_CSV);
$proxyListUpdater = new ProxyListUpdater(PROXY_LIST_CSV, $proxyRepository);
$requestParams = new RequestParams(
    '127.0.0.1:8080',
    'GET',
    [
        'User-Agent: Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36'
    ]);
$requestHandler = new RequestHandler();
$proxyServer = new ProxyServer($proxyRepository, $requestHandler, $requestParams);

// $proxyListUpdater->update();

$proxyServer->execute(
    nTimes:1,

    /*
    * -1 - http request without proxy servers
    * 0 - http request using all proxy servers
    * 1 - http request using 1-th proxy server
    * N - http request using the N-th proxy servers
    */
    nServers: 0 
);