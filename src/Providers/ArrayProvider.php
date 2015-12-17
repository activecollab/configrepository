<?php

namespace ActiveCollab\ConfigRepository\Providers;

use ActiveCollab\ConfigRepository\AdapterInterface;

class ArrayAdapter implements AdapterInterface
{
    /**
     * Configuration data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $array)
    {
        $this->data = $array;
    }

    /**
     * @return array
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
        if ($this->exists($name)) {
            return $this->data[$name];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        if (null === $name) {
            $this->data[] = $value;
        } else {
            $this->data[$name] = $value;
        }
    }
}
