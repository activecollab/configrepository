<?php

namespace ActiveCollab\ConfigRepository;

use ActiveCollab\ConfigRepository\Exception\InvalidArgumentException;
use ActiveCollab\ConfigRepository\Exception\OptionNotFound;
use ActiveCollab\ConfigRepository\Exception\RuntimeException;

/**
 * @package ActiveCollab\ConfigRepository
 */
class ConfigRepository implements ConfigRepositoryInterface
{
    /**
     * @var AdapterInterface[]
     */
    protected $adapters;

    /**
     * @param AdapterInterface[] ...$adapters
     */
    public function __construct(...$adapters)
    {
        foreach ($adapters as $adapter) {
            if (is_array($adapter)) {
                foreach ($adapter as $adapter_name => $a) {
                    if ($a instanceof AdapterInterface) {
                        $this->addAdapter($a, is_string($adapter_name) ? $adapter_name : get_class($a));
                    } else {
                        throw new InvalidArgumentException('Expected array of AdapterInterface instances or AdapterInterface instance');
                    }
                }
            } elseif ($adapter instanceof AdapterInterface) {
                $this->addAdapter($adapter);
            } else {
                throw new InvalidArgumentException('Expected array of AdapterInterface instances or AdapterInterface instance');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function &getAdapter($name)
    {
        if (isset($this->adapters[$name])) {
            return $this->adapters[$name];
        } else {
            throw new InvalidArgumentException("Provider '$name' not found in the config repository");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function &addAdapter(AdapterInterface $adapter, $name = null)
    {
        if (empty($name)) {
            $name = get_class($adapter);
        }

        if (empty($this->adapters[$name])) {
            $this->adapters[$name] = $adapter;
        } else {
            throw new RuntimeException("Adapter '$name' already added");
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->exists($name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, $default = null)
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->exists($name)) {
                return $adapter->get($name);
            }
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function mustGet($name)
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->exists($name)) {
                return $adapter->get($name);
            }
        }

        throw new OptionNotFound("Option '$name' not found in config providers");
    }

    /**
     * Magic function so that $obj->value will work.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->exists($name)) {
                $adapter->set($name, $value);
            }
        }
    }
}
