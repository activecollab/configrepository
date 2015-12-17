<?php

namespace ActiveCollab\ConfigRepository\Test;

use ActiveCollab\ConfigRepository\Adapter\DotEnvAdapter;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;
use ActiveCollab\ConfigRepository\ConfigRepository;

/**
 * @package ActiveCollab\ConfigRepository\Test
 */
class AddAdaptersTest extends TestCase
{
    public function testConstructorComposition()
    {
        $repository = new ConfigRepository(new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'), new DotEnvAdapter(__DIR__ . '/Resources', '.env'));

        $this->assertInstanceOf(PhpConstantsAdapter::class, $repository->getAdapter(PhpConstantsAdapter::class));
        $this->assertInstanceOf(DotEnvAdapter::class, $repository->getAdapter(DotEnvAdapter::class));
    }

    /**
     * Test composition from mix of arrays and adapter instances
     */
    public function testNamedComposition()
    {
        $repository = new ConfigRepository([
            new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'),
            'second' => new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'),
        ], new DotEnvAdapter(__DIR__ . '/Resources', '.env'));

        $this->assertInstanceOf(PhpConstantsAdapter::class, $repository->getAdapter(PhpConstantsAdapter::class));
        $this->assertInstanceOf(PhpConstantsAdapter::class, $repository->getAdapter('second'));
        $this->assertInstanceOf(DotEnvAdapter::class, $repository->getAdapter(DotEnvAdapter::class));
    }
}
