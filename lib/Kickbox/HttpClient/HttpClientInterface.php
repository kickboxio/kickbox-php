<?php

namespace Kickbox\HttpClient;

/**
 * Interface HttpClinetInterface
 * @package Kickbox\HttpClient
 */
interface HttpClientInterface
{
    /**
     * @param $path
     * @param array $params
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function get($path, array $params = [], array $options = []);

    /**
     * @param $path
     * @param $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function post($path, $body, array $options = []);

    /**
     * @param $path
     * @param $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function patch($path, $body, array $options = []);

    /**
     * @param $path
     * @param $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function delete($path, $body, array $options = []);

    /**
     * @param $path
     * @param $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function put($path, $body, array $options = []);
}
