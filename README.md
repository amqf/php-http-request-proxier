# PHP HTTP REQUEST PROXIER

Used for request a http web server N times with N proxy servers using a proxy server list.

![Image](./image.png "Como funciona?")

# Requeriments

- git
- PHP 8.3

# Installation

```
$ git clone https://github.com/amqf/php-http-request-proxier
```

# Usage

```php
use AMQF\HttpRequestProxier\ProxyListUpdater;
use AMQF\HttpRequestProxier\ProxyRepository;
use AMQF\HttpRequestProxier\ProxyServer;
use AMQF\HttpRequestProxier\RequestHandler;
use AMQF\HttpRequestProxier\RequestParams;

const PROXY_LIST_CSV = './proxy.csv';

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
```

## Proxy Server List Updating

```php
$userAgentRepository = new UserAgentRepository(USER_AGENT_LIST_CSV);
$proxyListUpdater = new ProxyListUpdater('./proxy.csv', $proxyRepository);
$proxyListUpdater->update();
```

# Web Server Simulation

You may request the "Web Server Simulator" executing:

```php
$ php ./webserver_simulator.php
// Servidor HTTP rodando em http://127.0.0.1:8080
```

Change `RequestParams` `host` and `port` in `index.php` and execute it:

```php
$ php ./index.php
```