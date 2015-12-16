<?php

namespace ActiveCollab\ConfigRepository\Providers;

class EnvProvider extends ArrayProvider
{
    /**
     * EnvProvider constructor.
     */
    public function __construct()
    {
        parent::__construct($_ENV);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        parent::set($name, $value);
        $_ENV[$name] = $value;
    }
}
