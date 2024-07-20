<?php

namespace AMQF\HttpRequestProxier;

class ProxyServer
{
    public function __construct(
        private ProxyRepository $_proxyRepository,
        private RequestHandler $_requestHandler,
        private RequestParams $_requestParams
    )
    {
        $this->_proxyRepository = $_proxyRepository;
        $this->_requestHandler = $_requestHandler;
        $this->_requestParams = $_requestParams;
    }

    /**
     * @var int $n_times
     * @var int $n_servers
     */
    public function execute(int $n_times, int $n_servers = 0)
    {
        echo __CLASS__ . ": Starting requests...\n";
        $proxies = $this->_proxyRepository->getProxies($n_servers);

        for ($i = 0; $i < $n_times; $i++) {

            if($n_servers === -1)
            {
                $this->_requestHandler->execute($this->_requestParams);
            }

            /**
             * @var array $proxies
             * @var ProxyAttributes $proxyAttributes
             */
            foreach ($proxies as $proxyAttributes) {
                $this->_requestHandler->execute($this->_requestParams, $proxyAttributes);
            }
        }
    }
}
