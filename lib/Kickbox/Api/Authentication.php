<?php

namespace Kickbox\Api;

use Kickbox\HttpClient\HttpClient;

class Authentication
{
    private $api_key;

    private $app_code;

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function __construct($api_key, $app_code)
    {
        $this->api_key = $api_key;
        $this->app_code = $app_code;
        $this->httpClient = new HttpClient();
    }



    public function authenticate($fingerprint, array $options = array())
    {
        $url = '/authenticate'. rawurlencode($this->app_code);
        $body = (isset($options['body']) ? $options['body'] : array());
        $body['fingerprint'] = $fingerprint;
        $body['api_key'] = $this->api_key;

        $response = $this->httpClient->post($url, $body, $options);

        return $response;
    }

    /**
     * GET status
     * getStatus - Get the status of an authentication
     * {@param} id {string} Authentication id returned from the auth request
     */
    public function getStatus($id, array $options = array())
    {
        $url = '/authenticate/'. rawurlencode($this->app_code) . '/' . rawurlencode($id);

        $body = (isset($options['query']) ? $options['query'] : array());
        $body['api_key'] = $this->api_key;

        $response = $this->httpClient->get($url, $body, $options);

        return $response;
    }


}
