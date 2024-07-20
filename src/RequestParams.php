<?php

namespace AMQF\HttpRequestProxier;

class RequestParams
{
    public function __construct(
        private string $_url,
        private string $_method = 'GET',
        private array $_headers = [],
        private ?string $_postFields = null
    )
    {
    }

    public function getUrl() : string
    {
        return $this->_url;
    }

    public function getMethod() : string
    {
        return $this->_method;
    }

    public function getHeaders() : array
    {
        return $this->_headers;
    }

    public function getPostFields() : ?string
    {
        return $this->_postFields;
    }

    public function __toString() : string
    {
        return sprintf(
            "method: %s | url: %s | headers: %s | postFields: %s",
            $this->_method,
            $this->_url,
            implode(', ', $this->_headers),
            $this->_postFields
        );
    }
}
