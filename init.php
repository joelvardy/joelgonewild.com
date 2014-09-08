<?php

define('BASE_PATH', realpath(dirname(__FILE__)));
define('APP_PATH', BASE_PATH.'/app');
define('ROUTES_PATH', APP_PATH.'/routes');
define('VIEWS_PATH', APP_PATH.'/views');

require(BASE_PATH.'/vendor/autoload.php');

Flight::set('flight.views.path', VIEWS_PATH);
