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

    public function execute(int $nTimes, int $nServers = 0) : void
    {
        echo __CLASS__ . ": Starting requests...\n";
        $proxies = $this->_proxyRepository->getProxies($nServers);

        for ($i = 0; $i < $nTimes; $i++) {

            if($nServers === -1)
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
