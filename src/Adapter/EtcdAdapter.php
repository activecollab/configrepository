<?php

namespace ActiveCollab\ConfigRepository\Adapter;

use ActiveCollab\ConfigRepository\AdapterInterface;
use ActiveCollab\Etcd\ClientInterface;
use ActiveCollab\Etcd\Exception\ExceptionInterface;
use Exception;

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
     * {@inheritdoc}
     */
    public function get($name, $default = null)
    {
        try {
            return $this->client->get($name);
        } catch (Exception $e) {
            if ($e instanceof  ExceptionInterface) {
                return $default;
            } else {
                throw $e;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        return $this->client->exists($name);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        $this->client->set($name, $value);
    }
}
