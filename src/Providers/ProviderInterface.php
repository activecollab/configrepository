<?php

namespace ActiveCollab\Configuration\Providers;

interface ProviderInterface
{
    /**
     * Returns config array.
     *
     * @return array
     */
    public function getData();
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
     * Check if $name exists.
     *
     * @param string $name
     * @return bool
     */
    public function exists($name);

    /**
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value);
}
