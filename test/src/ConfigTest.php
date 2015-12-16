<?php

namespace ActiveCollab\Configuration\Test;

use ActiveCollab\Configuration\Config;
use ActiveCollab\Configuration\Providers\EnvProvider;
use ActiveCollab\Configuration\Providers\FileProvider;
use ActiveCollab\Configuration\Providers\ServerProvider;

class ConfigTest extends TestCase
{
    /**
     * @dataProvider configFilesProvider
     */
    public function testFileConfigPhpRunOK($file)
    {
        $provider = new FileProvider($file);
        $conf = new Config($provider);
        $this->assertConfigValues($conf);
    }

    public function testEnvRunOk()
    {
        //set ENV
        $expected = 'test_is_ok';
        $_ENV['test_var'] = $expected;
        //Create config
        $env_provider = new EnvProvider();
        $conf = new Config($env_provider);
        //test
        $this->assertEquals($expected, $conf->test_var);
        //unset ENV
        unset($_ENV['test_var']);
    }

    public function testServerRunOk()
    {
        //set Server
        $expected = 'test_is_ok';
        $_SERVER['test_var'] = $expected;

        //Create config
        $server_provider = new ServerProvider();
        $conf = new Config($server_provider);
        //test
        $this->assertEquals($expected, $conf->test_var);
        //unset SERVER
        unset($_SERVER['test_var']);
    }

    public function configFilesProvider()
    {
        return [
            [__DIR__.'/PhpArray.php'],
            [__DIR__.'/XmlConfig.xml'],
            [__DIR__.'/JsonConfig.json'],
        ];
    }

    protected function assertConfigValues(Config $config)
    {
        //--------------------------
        //test __get
        //--------------------------
        $this->assertEquals('file_location', $config->log);
        $this->assertEquals('my_user', $config->db_user);
        $this->assertEquals('my_pass', $config->db_pass);
        $this->assertEquals('my_host', $config->db_host);
        //--------------------------
        //test default val
        //--------------------------
        $this->assertEquals('default_value', $config->get('no_name', 'default_value'));
    }
}
