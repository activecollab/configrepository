<?php

namespace ActiveCollab\ConfigRepository;

/**
 * @package ActiveCollab\ConfigRepository
 */
interface ConfigRepositoryInterface
{
    /**
     * Return adapter instance by adapter class name
     *
     * @param  string           $adapter_class
     * @return AdapterInterface
     */
    public function &getAdapter($adapter_class);

    /**
     * Add a provider to the repository.
     *
     * @param  AdapterInterface $adapter
     * @return $this
     */
    public function &addAdapter(AdapterInterface $adapter);

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
     * Retrieve a value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function mustGet($name);

    /**
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value);
}
