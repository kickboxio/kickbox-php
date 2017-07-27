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
        $body['email'] = $email;
        $body['timeout'] = $timeout;

        return $this->client->get('/v2/verify', $body, $options);
    }

    /**
     * Start a verify batch process
     * @param array $emails List of Email addresses
     * @param array $options Options for PUT request
     * @return \Kickbox\HttpClient\Response
     */
    public function verifyBatch($emails, array $options = [])
    {
        if(empty($options['headers'])) {
            $options['headers'] = [];
        }
        $options['headers'] = array_merge([
            'Content-Type' => 'text/csv',
            'X-Kickbox-Filename' => 'Batch API Process - '.date('m-d-Y-H-i-s')
        ], $options['headers']);
        $emails = join("\n", $emails);
        return $this->client->put('/v2/verify-batch', $emails, $options);
    }

    /**
     * Get a batch result
     * @param integer $id Batch ID to check
     * @param array $options Options for GET request
     * @return \Kickbox\HttpClient\Response
     */
    public function getBatchResults($id, array $options = []) {
        return $this->client->get('/v2/verify-batch/'.$id, [], $options);
    }

    /**
     * Check if an email is isDisposable
     * @param string $email Email address to check
     * @param array $options Options for GET request
     * @return \Kickbox\HttpClient\Response
     */
    public function isDisposable($email, array $options = []) {
        $options = array_merge([
            'base_uri'    => 'https://open.kickbox.io',
            'api_version' => 'v1',
        ], $options);
        return $this->client->get('/v1/disposable/'.$email, [], $options);
    }

    /**
     * Check the credit balance
     * @param array $options Options for GET request
     * @return \Kickbox\HttpClient\Response
     */
    public function getCreditBalance(array $options = []) {
        return $this->client->get('/v2/balance', [], $options);
    }
}
