<?php

namespace ActiveCollab\ConfigRepository\Test;

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;

/**
 * @package ActiveCollab\ConfigRepository\Test
 */
class PhpConstantsAdapterTest extends TestCase
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

    /**
     * Test get value
     */
    public function testGet()
    {
        $this->assertSame(1, $this->repository->get('FIRST'));
        $this->assertSame('not-found', $this->repository->get('NOT FOUND', 'not-found'));
    }

    /**
     * Test must get value
     */
    public function testMustGet()
    {
        $this->assertSame(1, $this->repository->mustGet('FIRST'));
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