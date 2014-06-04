<?php

namespace Kickbox\HttpClient;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Response;

use Kickbox\HttpClient\ResponseHandler;
use Kickbox\Exception\ClientException;

/**
 * ErrorHanlder takes care of selecting the error message from response body
 */
class ErrorHandler
{
    public function onRequestError(Event $event)
    {
        $request = $event['request'];
        $response = $request->getResponse();

        $message = null;
        $code = $response->getStatusCode();

        if ($response->isServerError()) {
            throw new ClientException('Error '.$code, $code);
        }

        if ($response->isClientError()) {
            $body = ResponseHandler::getBody($response);

            // If HTML, whole body is taken
            if (gettype($body) == 'string') {
                $message = $body;
            }

            // If JSON, a particular field is taken and used
            if ($response->isContentType('json') && is_array($body)) {
                if (isset($body['message'])) {
                    $message = $body['message'];
                } else {
                    $message = 'Unable to select error message from json returned by request responsible for error';
                }
            }

            if (empty($message)) {
                $message = 'Unable to understand the content type of response returned by request responsible for error';
            }

            throw new ClientException($message, $code);
        }
    }
}
