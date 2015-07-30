<?php

namespace Kickbox\Api;

use Kickbox\HttpClient\HttpClient;

/**
 *
 */
class Kickbox
{

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
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

        $response = $this->client->get('/verify?email='.rawurlencode($email).'&timeout='.$timeout.'', $body, $options);

        return $response;
    }

}
