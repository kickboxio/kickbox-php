<?php

namespace Kickbox\Api;

use Kickbox\HttpClient\HttpClientInterface;

class Kickbox implements KickboxInterface
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function verify($email, array $options = [])
    {
        $body = isset($options['query']) ? $options['query'] : [];
        $timeout = isset($options['timeout']) ? $options['timeout'] : 6000;
        $body['email'] = rawurlencode($email);
        $body['timeout'] = $timeout;

        return $this->client->get('/v2/verify', $body, $options);
    }
}
