<?php

namespace Kickbox;

use Kickbox\HttpClient\HttpClient;

class Client
{
    private $httpClient;

    public function __construct($auth = array(), array $options = array())
    {
        $this->httpClient = new HttpClient($auth, $options);
    }

    /**
     * 
     */
    public function kickbox()
    {
        return new Api\Kickbox($this->httpClient);
    }

}
