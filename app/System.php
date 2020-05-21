<?php

namespace Project;

use Phalcon\Config\Adapter\Ini as Config;
use Phalcon\Http\Request;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Project\Di as ProjectDi;

/**
 * Class System
 *
 * @package Project
 */
class System
{
    /**
     * @var Config
     */
    protected $_config;

    /**
     * start
     *
     * @return void
     */
    public function start()
    {
        // register an autoloader and a set namespaces
        $loader = new Loader();

        $fullNamespaces = array_map(function ($value) {
            return APP_PATH . $value;
        }, $this->getConfig()->namespaces->toArray());

        $loader->registerNamespaces($fullNamespaces);
        $loader->register();

        try {
            // initialize application and its services
            $application = new Application(new ProjectDi());

            $request = new Request();

            // handling requests
            $response = $application->handle($request->getURI());

            $response->send();
        } catch (\Exception $e) {
            echo "Exception: ", $e->getMessage();
        } catch (\Error $err) {
            echo "Error: ", $err->getMessage();
        }
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        if (!$this->_config) {
            $this->_config = new Config(APP_PATH . '/config.ini');
        }

        return $this->_config;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config): void
    {
        $this->_config = $config;
    }
}
