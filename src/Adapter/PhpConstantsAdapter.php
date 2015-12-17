<?php

namespace ActiveCollab\ConfigRepository\Adapter;

use ActiveCollab\ConfigFile\ConfigFile;
use ActiveCollab\ConfigRepository\Exception\LogicException;
use ActiveCollab\ConfigRepository\AdapterInterface;

/**
 * @package ActiveCollab\ConfigRepository\Providers
 */
class PhpConstantsAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param $file_path
     */
    public function __construct($file_path)
    {
        $this->data = (new ConfigFile($file_path))->getOptions();
    }

    /**
     * Returns config array.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
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
        return $this->exists($name) ? $this->data[$name] : $default;
    }

    /**
     * Check if $name exists.
     *
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * Set a value in the config.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        throw new LogicException('PHP constant files are read only');
    }
}
