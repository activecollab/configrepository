<?php

namespace ActiveCollab\ConfigRepository;

/**
 * @package ActiveCollab\ConfigRepository
 */
interface ConfigRepositoryInterface
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
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value);
}
