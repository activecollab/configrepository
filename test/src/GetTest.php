<?php

namespace ActiveCollab\ConfigRepository\Test;

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\PhpConstandsAdapter;

/**
 * @package ActiveCollab\ConfigRepository\Test
 */
class GetTest extends TestCase
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

        $this->repository = new ConfigRepository(new PhpConstandsAdapter(__DIR__ . '/Resources/config.get_test.php'));
    }

    /**
     * Test get existing option
     */
    public function testFindAndGet()
    {
        $this->assertSame(1, $this->repository->get('FIRST'));
    }

    /**
     * Test if default is returned when option does not exist
     */
    public function testDefaultWhenNotFound()
    {
        $this->assertSame('not-found', $this->repository->get('NOT FOUND FOR SURE', 'not-found'));
    }

    public function testFindAndMustGet()
    {
        $this->assertSame(2, $this->repository->mustGet('SECOND'));
    }

    /**
     * @expectedException \ActiveCollab\ConfigRepository\Exception\OptionNotFound
     */
    public function testMustGetNotFoundException()
    {
        $this->repository->mustGet('NOT FOUND FOR SURE');
    }
}
