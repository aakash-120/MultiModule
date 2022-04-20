<?php
// print_r(apache_get_modules());
// echo "<pre>"; print_r($_SERVER); die;
// $_SERVER["REQUEST_URI"] = str_replace("/phalt/","/",$_SERVER["REQUEST_URI"]);
// $_GET["_url"] = "/";
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Mvc\Router;

require_once __DIR__.'/vendor/autoload.php' ;

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
    ]
);

$loader->register();

$container = new FactoryDefault();


$container->set(
    'router',
    function () {
        $router = new Router();

        $router->setDefaultModule('admin');

        $router->add(
            '/admin/login/:action',
            [
                'module'     => 'admin',
                'controller' => 'login',
                'action'     => 1,
            ]
        );
        $router->add(
            '/admin',
            [
                'module'     => 'admin',
                'controller' => 'index',
                'action'     => 'index',
            ]
        );
        $router->add(
            '/admin/addproduct/:action',
            [
                'module'     => 'admin',
                'controller' => 'addproduct',
                'action'     => 1,
            ]
        );
    
        $router->add(
            '/admin/displayproduct/:action',
            [
                'module'     => 'admin',
                'controller' => 'displayproduct',
                'action'     => 1,
            ]
        );
        $router->add(
            '/signup/:action',
            [
                'module'     => 'admin',
                'controller' => 'signup',
                'action'     => 1,
            ]
        );

        $router->add(
            '/',
            [
                'module'     => 'admin',
                'controller' => 'login',
                'action'     => 'index',
            ]
        );

        // $router->add(
        //     '/products/:action',
        //     [
        //         'controller' => 'products',
        //         'action'     => 1,
        //     ]
        // );

        return $router;
    }
);


// $container->set(
//     'view',
//     function () {
//         $view = new View();
//         $view->setViewsDir(APP_PATH . '/views/');
//         return $view;
//     }
// );
$application = new Application($container);

$application->registerModules(
    [
        'front' => [
            'className' => \Multi\Front\Module::class,
            'path'      => APP_PATH.'/front/Module.php',
        ],
        'admin'  => [
            'className' => \Multi\Admin\Module::class,
            'path'      => APP_PATH.'/admin/Module.php',
        ]
    ]
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);




// $container->set(
//     'db',
//     function () {
//         return new Mysql(
//             [
//                 'host'     => 'localhost',
//                 'username' => 'root',
//                 'password' => '',
//                 'dbname'   => 'phalt',
//                 ]
//             );
//         }
// );

// $container->set(
//     'mongo',
//     function () {
//         $mongo = new MongoClient();

//         return $mongo->selectDB('test');
//     },
//     true
// );
$container->set(
    'mongo',
    function () {
        $mongo = new \MongoDB\Client("mongodb://mongo", array("username" => 'root', "password" => "password123"));

        return $mongo ;
    },
    true
);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}
