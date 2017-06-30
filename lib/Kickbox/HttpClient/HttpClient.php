<?php

namespace Kickbox\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Class HttpClient
 * @package Kickbox\HttpClient
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private static $options = [
        'base_uri'    => 'https://api.kickbox.io',
        'api_version' => 'v2',
        'headers' => [
            'user-agent' => 'kickbox-php/2.2.2 (https://github.com/kickboxio/kickbox-php)'
        ]
    ];

    /**
     * @param string $auth
     * @param array $options
     */
    public function __construct($auth = '', array $options = [])
    {
        $options = array_merge(self::$options, $options);

        $options['headers']['Authorization'] = sprintf('token %s', $auth);
        $this->client = new Client($options);
    }

    /**
     * {@inheritdoc}
     */
    public function get($path, array $params = [], array $options = [])
    {
        return $this->request($path, [], 'GET', array_merge($options, ['query' => $params]));
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'POST', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'PATCH', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'DELETE', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function put($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'PUT', $options);
    }

    /**
     * @param $path
     * @param array $body
     * @param string $httpMethod
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    private function request($path, array $body = [], $httpMethod = 'GET', array $options = [])
    {
        if (isset($options['body'])) {
            $body = array_merge($options['body'], $body);
        }

        $headers = [];
        if (isset($options['headers'])) {
            $headers = $options['headers'];
            unset($options['headers']);
        }

        $options['body'] = json_encode($body);
        $options['headers'] = array_merge($headers, self::$options['headers']);
        $options = array_merge($options, self::$options);

        try {
            $response = $this->client->request($httpMethod, $path, $options);
        } catch (BadResponseException $e) {
            throw new \ErrorException($e->getMessage(), $e->getResponse()->getStatusCode());
        } catch (\LogicException $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode());
        } catch (\RuntimeException $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode());
        }

        return new Response(json_decode($response->getBody()->getContents(), true), $response->getStatusCode());
    }
}
