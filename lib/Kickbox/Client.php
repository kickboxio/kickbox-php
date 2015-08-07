<?php

namespace Kickbox;

use Kickbox\HttpClient\HttpClient;

class Client
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param array $auth
     * @param array $options
     */
    public function __construct($auth = array(), array $options = array())
    {
        $this->httpClient = new HttpClient($auth, $options);
    }

    /**
     * @return Api\Kickbox
     */
    public function kickbox()
    {
        return new Api\Kickbox($this->httpClient);
    }

}
