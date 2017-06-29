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
     * @param string $auth
     * @param array $options
     */
    public function __construct($auth = '', array $options = [])
    {
        $this->httpClient = new HttpClient($auth, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function kickbox()
    {
        return new Api\Kickbox($this->httpClient);
    }
}
