<?php

declare (strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;

if (session_start()) {
// autoload class definition files,
// according to the autoload section of composer.json
    require 'vendor/autoload.php';

// define paths
    $base_dir = dirname(__DIR__);
    $app_dir = $base_dir . '/doctrine_sessions/app/';
    $config_dir = $app_dir . 'config/';
    $routes_dir = $app_dir . 'routes/';

// Create Container using PHP-DI
    $container = new Container();

// Inject the container into the AppFactory, then instantiate the app
    AppFactory::setContainer($container);

    $app = AppFactory::create();

// tell SLIM the location of the application
    $app->setBasePath("/ctec3110/lab_07/doctrine_sessions");

    // make the settings available
    $settings = require $config_dir . 'settings.php';
    $settings($container, $app_dir);

    $middleware = require $config_dir . 'middleware.php';
    $middleware($app);

    // make the dependencies available
    $dependencies = require $config_dir . 'dependencies.php';
    $dependencies($container, $app);

    require $routes_dir . 'routes.php';

    $app->run();

}

