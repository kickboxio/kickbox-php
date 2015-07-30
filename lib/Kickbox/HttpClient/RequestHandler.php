<?php

namespace Kickbox\HttpClient;

use Guzzle\Http\Message\RequestInterface;

/**
 * RequestHandler takes care of encoding the request body into format given by options
 */
class RequestHandler {

    /**
     * @param RequestInterface $request
     * @param \Guzzle\Http\EntityBodyInterface|string $body
     * @param array $options
     * @return mixed
     */
    public static function setBody(RequestInterface $request, $body, $options)
    {
        $type = isset($options['request_type']) ? $options['request_type'] : 'raw';
        $header = null;

        if ($type == 'raw') {
            // Raw body
            return $request->setBody($body, $header);
        }
    }

}
