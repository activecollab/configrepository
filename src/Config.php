<?php

namespace ActiveCollab\Configuration;

use ActiveCollab\Configuration\Providers\EnvProvider;
use ActiveCollab\Configuration\Providers\ProviderInterface;
use ActiveCollab\Configuration\Providers\ServerProvider;

class Config implements ConfigInterface
{
    /**
     * Configuration data.
     *
     * @var array
     */
    protected $provider;

    /**
     * @var bool
     */
    protected $is_global = false;

    public function __construct(ProviderInterface $config_provider)
    {
        if ($config_provider instanceof EnvProvider || $config_provider instanceof ServerProvider) {
            $this->is_global = true;
        }
        $this->provider = $config_provider;
    }

    /**
     * Retrieve a value and return $default if there is no element set.
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return $this->provider->get($name, $default);
    }

    /**
     * Check if $name exists.
     *
     * @param $name
     *
     * @return bool
     */
    public function exists($name)
    {
        return $this->provider->exists($name);
    }
    /**
     * Magic function so that $obj->value will work.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        return $this->provider->set($name, $value);
    }

    public function isGlobal()
    {
        return $this->is_global;
    }
}
