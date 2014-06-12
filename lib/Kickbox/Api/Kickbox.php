<?php

namespace Kickbox\Api;

use Kickbox\HttpClient\HttpClient;

/**
 * 
 */
class Kickbox
{

    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Email Verification
     *
     * '/verify?email=:email' GET
     *
     * @param $email Email address to verify
     */
    public function verify($email, array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('/verify?email='.rawurlencode($email).'', $body, $options);

        return $response;
    }

}
