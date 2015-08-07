<?php

namespace Kickbox\HttpClient;

use Guzzle\Common\Event;

/**
 * AuthHandler takes care of devising the auth type and using it
 */
class AuthHandler
{
    /**
     * @var array
     */
    private $auth;

    const HTTP_HEADER = 1;

    /**
     * @param array $auth
     */
    public function __construct(array $auth = array())
    {
        $this->auth = $auth;
    }

    /**
     * Calculating the Authentication Type
     */
    public function getAuthType()
    {

        if (isset($this->auth['http_header'])) {
            return self::HTTP_HEADER;
        }

        return -1;
    }

    /**
     * @param Event $event
     * @throws \ErrorException
     */
    public function onRequestBeforeSend(Event $event)
    {
        if (empty($this->auth)) {
            throw new \ErrorException('Server requires authentication to proceed further. Please check');
        }

        $auth = $this->getAuthType();
        $flag = false;

        if ($auth == self::HTTP_HEADER) {
            $this->httpHeader($event);
            $flag = true;
        }

        if (!$flag) {
            throw new \ErrorException('Unable to calculate authorization method. Please check.');
        }
    }

    /**
     * Authorization with HTTP header
     *
     * @param Event $event
     */
    public function httpHeader(Event $event)
    {
        $event['request']->setHeader('Authorization', sprintf('token %s', $this->auth['http_header']));
    }

}
