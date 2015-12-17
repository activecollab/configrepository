<?php

namespace ActiveCollab\ConfigRepository\Test;

use ActiveCollab\ConfigRepository\CompositeConfig;
use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Providers\ArrayAdapter;
use ActiveCollab\ConfigRepository\Providers\EnvProvider;
use ActiveCollab\ConfigRepository\Providers\ServerProvider;

class CompositeConfigTest extends TestCase
{
    protected $composite_config;
    protected $prefix = 'zxcvbnmasdfghjkl';
    protected $separator = '/';
    protected $user_email = 'name.surname@activecollab.com';

    public function setUp()
    {
        parent::setUp();

        $_ENV['key1'] = 'val1';
        $_ENV['key2'] = 'val2';
        $_ENV['key3'] = 'val3';
        $env_provider = new EnvProvider();
        $env_config = new ConfigRepository($env_provider);

        $_SERVER['key3'] = 'val3-srv';
        $_SERVER['key4'] = 'val4';
        $_SERVER['key5'] = 'val5';
        $srv_provider = new ServerProvider();
        $srv_config = new ConfigRepository($srv_provider);

        $array = [
            'key6' => 'val6',
            'key7' => 'val7',
            'key8' => 'val8',
            $this->prefix.$this->separator.'key9' => 'val9',
            $this->prefix.$this->separator.'key10' => 'val10',
            $this->prefix.$this->separator.$this->user_email.$this->separator.'key11' => 'val11',
            $this->prefix.$this->separator.$this->user_email.$this->separator.'key12' => 'val12',
        ];
        $array_provider = new ArrayAdapter($array);
        $array_config = new ConfigRepository($array_provider);
        //config will first look in env than server and at last array config
        $this->composite_config = new CompositeConfig([$env_config, $srv_config, $array_config]);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($_ENV['key1']);
        unset($_ENV['key2']);
        unset($_ENV['key3']);

        unset($_SERVER['key3']);
        unset($_SERVER['key4']);
        unset($_SERVER['key5']);
    }

    public function testGetValue()
    {
        $this->assertEquals('val1', $this->composite_config->getGlobal('key1'));
        $this->assertEquals('val3', $this->composite_config->getGlobal('key3'));
        $this->assertEquals('val4', $this->composite_config->getGlobal('key4'));

        $this->assertEquals('val6', $this->composite_config->get('key6'));
        $this->assertEquals('val7', $this->composite_config->get('key7'));
        $this->composite_config->setPrefix($this->prefix);
        $this->assertEquals('val9', $this->composite_config->get('key9'));
        $this->assertEquals('val10', $this->composite_config->get('key10'));

        $this->assertEquals('val11', $this->composite_config->getUser('key11', $this->user_email));
        $this->assertEquals('val12', $this->composite_config->getUser('key12', $this->user_email));
    }

    public function testSetValue()
    {
        $this->composite_config->set('key678', 678);
        $this->assertEquals($this->composite_config->get('key678'), 678);

        $this->composite_config->setGlobal('key55', 'val55');

        $this->assertEquals($_ENV['key55'], 'val55');
        $this->assertEquals($_SERVER['key55'], 'val55');

        unset($_ENV['key55']);
        unset($_ENV['key55']);
    }
}
