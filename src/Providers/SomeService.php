<?php

namespace ActiveCollab\Configuration\Providers;

class SomeService implements ProviderInterface
{
    protected $data = [];
    protected $service;
    public function __construct($connection)
    {
        $this->service = $connection;//new ServiceX($connection)
    }
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * {@inheritdoc}
     */
    public function get($name, $default = null)
    {
        //if val exists in $data then $data[$name]
        //else
        //$val = $this->service->get(...)
        //store val to $data
        //$this->data[$name] = $val;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        //$this->service->exists(...)
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        //$this->service->set(...)
        //store val to $data
        //$this->data[$name] = $val;
    }
}
