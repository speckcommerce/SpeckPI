<?php

namespace SpeckPI;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SpeckPI\Service\PIService' => function($sm) {
                    $service = new Service\PIService;
                    $service->setPIMapper($sm->get('SpeckPI\Mapper\PIMapper'))
                        ->setEventManager($sm->get('EventManager'))
                        ->attachDefaultListeners();

                    return $service;
                },

                'SpeckPI\Mapper\PIMapper' => function($sm) {
                    $mapper = new Mapper\PIMapper;
                    $mapper->setDbAdapter($sm->get('speckcart_db_adapter'));
                    return $mapper;
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
}
