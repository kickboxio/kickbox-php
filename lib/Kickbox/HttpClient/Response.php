<?php

namespace Kickbox\HttpClient;

/*
 *
 */
class Response
{
    /**
     * @var array
     */
    public $body;

    /**
     * @var int
     */
    public $code;

    /**
     * @var array|null
     */
    public $headers;

    /**
     * @param array|string|\Guzzle\Http\EntityBodyInterface $body
     * @param int $code
     * @param array|null
     */
    public function __construct($body, $code, $headers = null)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
    }
}
