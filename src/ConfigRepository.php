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
    public function __construct(AdapterInterface ...$adapters)
    {
        foreach ($adapters as $adapter) {
            $this->addAdapter($adapter);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function &getAdapter($adapter_class)
    {
        if (isset($this->adapters[$adapter_class])) {
            return $this->adapters[$adapter_class];
        } else {
            throw new InvalidArgumentException("Provider '$adapter_class' not found in the config repository");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function &addAdapter(AdapterInterface $adapter)
    {
        $adapter_class = get_class($adapter);

        if (empty($this->adapters[$adapter_class])) {
            $this->adapters[$adapter_class] = $adapter;
        } else {
            throw new RuntimeException("Provider '$adapter_class' already added");
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
