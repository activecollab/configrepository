<?php

namespace ActiveCollab\ConfigRepository\Adapter;

use ActiveCollab\ConfigRepository\Exception\LogicException;
use ActiveCollab\ConfigRepository\AdapterInterface;
use Dotenv\Dotenv;

/**
 * @package ActiveCollab\ConfigRepository\Providers
 */
class DotEnvAdapter implements AdapterInterface
{
    /**
     * @var Dotenv
     */
    private $dotenv = [];

    /**
     * DotEnvAdapter constructor.
     *
     * @param string $path
     * @param string $file
     */
    public function __construct($path, $file = '.env')
    {
        $this->dotenv = new Dotenv($path, $file);
        $this->dotenv->load();
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
        return $this->exists($name) ? $_ENV[$name] : $default;
    }

    /**
     * Check if $name exists.
     *
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return array_key_exists($name, $_ENV);
    }

    /**
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        throw new LogicException('Environment variables are read only');
    }
}
