<?php

namespace ActiveCollab\ConfigRepository\Test;

use ActiveCollab\ConfigRepository\Adapter\DotEnvAdapter;
use ActiveCollab\ConfigRepository\ConfigRepository;

/**
 * @package ActiveCollab\ConfigRepository\Test
 */
class DotEnvAdapterTest extends TestCase
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

        $this->repository = new ConfigRepository(new DotEnvAdapter(__DIR__ . '/Resources', '.env'));
    }

    /**
     * Test if option exists if an adapter
     */
    public function testExists()
    {
        $this->assertTrue($this->repository->exists('FIRST'));
        $this->assertFalse($this->repository->exists('NOT FOUND'));
    }

    /**
     * Test get value
     */
    public function testGet()
    {
        $this->assertEquals(1, $this->repository->get('FIRST'));
        $this->assertSame('not-found', $this->repository->get('NOT FOUND', 'not-found'));
    }

    /**
     * Test must get value
     */
    public function testMustGet()
    {
        $this->assertEquals(1, $this->repository->mustGet('FIRST'));
    }

    /**
     * @expectedException \ActiveCollab\ConfigRepository\Exception\OptionNotFound
     */
    public function testMustGetExceptionWhenOptionIsNotFound()
    {
        $this->repository->mustGet('NOT FOUND FOR SURE');
    }

    /**
     * @expectedException \ActiveCollab\ConfigRepository\Exception\LogicException
     */
    public function testSet()
    {
        $this->repository->set('FIRST', 12);
    }
}