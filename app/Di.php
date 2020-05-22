<?php

namespace Project;

use Phalcon\Config\Adapter\Ini as Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Project\Constant\Service;

/**
 * Class Project
 *
 * @package Project
 * @info    Project-specific extension of Phalcon's FactoryDefault dependency container.
 */
class Di extends FactoryDefault
{
    /**
     * @var Config
     */
    protected $_config;

    /**
     * Di constructor.
     */
    public function __construct()
    {
        // setup global config
        $this->set(Service::CONFIG, $this->getConfig());

        // setup events manager
        $this->set(Service::EVENTS_MANAGER, function() {
            $eventsManager = new Manager();

            return $eventsManager;
        });

        // setup routing from configuration file
        $this->set(Service::ROUTER, function () {
            $router = new Router();

            return $router;
        });

       $this->set(Service::REQUEST, function () {
            return new Request();
        });

        // setup dispatcher: global event manager + default namespace
        $this->set(Service::DISPATCHER, function () {
            $eventsManager = $this->getShared(Service::EVENTS_MANAGER);

            $dispatcher = new Dispatcher();

            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Project\\Controller');

            return $dispatcher;
        });

        // setup URL service
        $this->set(Service::URL, function () {
            $url = new Url();

            $url->setBaseUri($this->getShared(Service::CONFIG)->application->baseUri);

            return $url;
        });

        // setup the view component
        $this->set(Service::VIEW, function () {
            $view = new View();
            $view->setViewsDir(APP_PATH . '/View/');

            return $view;
        });
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