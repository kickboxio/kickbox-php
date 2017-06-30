<?php

namespace Kickbox\Api;

use Kickbox\HttpClient\Response;

interface KickboxInterface
{
    /**
     * @param $email
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function verify($email, array $options = []);
}
