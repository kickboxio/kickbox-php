<?php

namespace Kickbox\Exception;

/**
 * ClientException is used when the api returns an error
 */
class ClientException extends \ErrorException
{
    public $code = null;

    public function __construct($message, $code)
    {
        $this->code = $code;
        parent::__construct($message, $code);
    }
}
