<?php

namespace Multi\Front;

use Phalcon\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(
        DiInterface $container = null
    )
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'Multi\Front\Controllers' => '../app/front/controllers/',
                'Multi\Front\Models'      => '../app/front/models/',
            ]
        );

        $loader->register();
    }

    public function registerServices(DiInterface $container)
    {
        // Registering a dispatcher
        $container->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace(
                    'Multi\Front\Controllers'
                );

                return $dispatcher;
            }
        );
        $container->set(
            'view',
            function () {
                $view = new View();
                $view->setViewsDir(
                    '../app/front/views/'
                );

                return $view;
            }
        );
    }
}