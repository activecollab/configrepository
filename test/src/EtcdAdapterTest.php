<?php

namespace ActiveCollab\ConfigRepository\Test;

use ActiveCollab\ConfigRepository\Adapter\EtcdAdapter;
use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\Etcd\Client;

/**
 * @package ActiveCollab\ConfigRepository\Test
 */
class EtcdAdapterTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

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

        $this->client = new Client();

        if ($this->client->dirExists('/phpunit_test')) {
            $this->client->removeDir('/phpunit_test', true);
        }

        $this->client->createDir('/phpunit_test');
        $this->client->setSandboxPath('/phpunit_test');
        $this->client->set('FIRST', 1);
        $this->client->set('SECOND', 2);

        $this->repository = new ConfigRepository(new EtcdAdapter($this->client));
    }

    public function tearDown()
    {
        $this->client->setSandboxPath('/');

        if ($this->client->dirExists('/phpunit_test')) {
            $this->client->removeDir('/phpunit_test', true);
        }

        parent::tearDown();
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
     * Test set value
     */
    public function testSet()
    {
        $this->repository->set('FIRST', 12);
        $this->assertEquals(12, $this->repository->get('FIRST'));
    }
}
