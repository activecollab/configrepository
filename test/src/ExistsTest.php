<?php

namespace ActiveCollab\ConfigRepository\Test;

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;

/**
 * @package ActiveCollab\ConfigRepository\Test
 */
class ExistsTest extends TestCase
{
    /**
     * @var ConfigRepository
     */
    private $repository;

    /**
     * Set up test environment
     */
    public function setUp()
    {
        parent::setUp();

        $this->repository = new ConfigRepository(new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'));
    }

    /**
     * Test if option exists if an adapter
     */
    public function testExists()
    {
        $this->assertTrue($this->repository->exists('FIRST'));
        $this->assertFalse($this->repository->exists('NOT FOUND'));
    }
}
