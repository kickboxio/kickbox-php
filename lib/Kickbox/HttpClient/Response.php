<?php

namespace Kickbox\HttpClient;

/*
 * Response object contains the response returned by the client
 */
class Response
{
    /**
     * @var string|\Guzzle\Http\EntityBodyInterface
     */
    public $body;

    /**
     * @var int
     */
    public $code;

    /**
     * @var array|\Guzzle\Http\Message\Header\HeaderCollection
     */
    public $headers;

    /**
     * @param string|\Guzzle\Http\EntityBodyInterface $body
     * @param int $code
     * @param array|\Guzzle\Http\Message\Header\HeaderCollection $headers
     */
    public function __construct($body, $code, $headers) {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
    }
}
