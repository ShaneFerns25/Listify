<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once 'vendor/autoload.php';
require_once 'routes/email-availability.php';
require_once 'routes/delete.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);

checkEmailAvailability($app);
deleteProduct($app);

$app->run();