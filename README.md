# PHP HTTP REQUEST PROXIER

It request a http web server N times with N proxy servers using a list.

![Image](./image.png "Como funciona?")

# Usage

```php
use AMQF\HttpRequestProxier\ProxyRepository;
use AMQF\HttpRequestProxier\ProxyServer;
use AMQF\HttpRequestProxier\RequestHandler;
use AMQF\HttpRequestProxier\RequestParams;
use AMQF\HttpRequestProxier\ProxyListUpdater;
use AMQF\HttpRequestProxier\UserAgentListUpdater;
use AMQF\HttpRequestProxier\UserAgentRepository;

$proxyRepository = new ProxyRepository(PROXY_LIST_CSV);
$userAgentRepository = new UserAgentRepository(USER_AGENT_LIST_CSV);
$userAgentListUpdater = new UserAgentListUpdater(USER_AGENT_LIST_CSV, $userAgentRepository);
$requestParams = new RequestParams(
    '127.0.0.1:8080',
    'GET',
    [
        'User-Agent: Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36'
    ]);
$requestHandler = new RequestHandler();
$proxyServer = new ProxyServer($proxyRepository, $requestHandler, $requestParams);

// Execute a requisição 1 vezes, considerando -1 (nenhum proxy), 0 (todos os proxies), N proxies
$proxyServer->execute(1, -1);
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
$ ./webserver_simulation.php
```

Change `RequestParams` `host` and `port` in `index.php` and it:

```php
$ php index.php
```