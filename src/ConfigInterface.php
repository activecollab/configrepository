<?php

namespace ActiveCollab\Configuration;

interface ConfigInterface
{
    /**
     * Retrieve a value and return $default if there is no element set.
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * Magic function so that $obj->value will work.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name);

    /**
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value);
}
