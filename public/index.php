<?php

require(dirname(__DIR__) . '/init.php');

foreach (glob(ROUTES_PATH . '/*.php') as $route) {
    require($route);
}

Flight::start();
