<?php

namespace ActiveCollab\ConfigRepository\Providers;

class ServerProvider extends ArrayProvider
{
    /**
     * ServerProvider constructor.
     */
    public function __construct()
    {
        parent::__construct($_SERVER);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        parent::set($name, $value);
        $_SERVER[$name] = $value;
    }
}
