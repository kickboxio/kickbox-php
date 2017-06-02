<?php

namespace Kickbox\Api;

use Kickbox\HttpClient\HttpClient;

class Verification
{

    /**
     * @var HttpClient
     */
    private $httpClient;

    private $api_key;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->httpClient = new HttpClient();
    }

    /**
     * Email Verification
     *
     * '/verify?email=:email&timeout=:timeout' GET
     *
     * @param string $email Email address to verify
     * @param array $options
     * @return \Kickbox\HttpClient\Response
     */
    public function verify($email, array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $timeout = (isset($options['timeout']) ? $options['timeout'] : 6000);

        $body['email'] = $email;
        $body['timeout'] = $timeout;
        $body['api_key'] = $this->api_key;

        $response = $this->httpClient->get('/verify', $body, $options);

        return $response;
    }

}
