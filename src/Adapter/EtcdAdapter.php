<?php

namespace ActiveCollab\ConfigRepository\Adapter;

use ActiveCollab\ConfigRepository\AdapterInterface;
use ActiveCollab\Etcd\ClientInterface;
use ActiveCollab\Etcd\Exception\KeyNotFoundException;

/**
 * @package ActiveCollab\ConfigRepository\Providers
 */
class EtcdAdapter implements AdapterInterface
{
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
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
        return $this->exists($name) ? $this->client->get($name) : $default;
    }

    /**
     * Check if $name exists.
     *
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        try {
            $this->client->get($name);
            return true;
        } catch (KeyNotFoundException $e) {
            return false;
        }
    }

    /**
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $this->client->set($name, $value);
    }
}
