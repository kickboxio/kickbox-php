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
     * '/verify?email=:email&timeout=:timeout' GET
     *
     * @param $email Email address to verify
     */
    public function verify($email, array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $timeout = (isset($options['timeout']) ? $options['timeout'] : 6000);

        $response = $this->client->get('/verify?email='.rawurlencode($email).'&timeout='.$timeout.'', $body, $options);

        return $response;
    }

}
