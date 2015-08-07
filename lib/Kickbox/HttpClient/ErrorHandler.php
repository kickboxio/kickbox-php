<?php

namespace Kickbox\HttpClient;

use Guzzle\Common\Event;

use Kickbox\Exception\ClientException;

/**
 * ErrorHandler takes care of selecting the error message from response body
 */
class ErrorHandler
{
    /**
     * @param Event $event
     * @throws ClientException
     */
    public function onRequestError(Event $event)
    {
        /** @var \Guzzle\Http\Message\Request $request */
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
