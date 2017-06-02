<?php

namespace Kickbox;

class Client
{
    /**
     * @return Api\Verification
     */
    public function Verification($api_key)
    {
        return new Api\Verification($api_key);
    }

    /**
     * @return Api\Authentication
     */
    public function Authentication($api_key, $app_code)
    {
        return new Api\Authentication($api_key, $app_code);
    }

}
