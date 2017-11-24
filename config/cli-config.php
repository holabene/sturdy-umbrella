<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';

return ConsoleRunner::createHelperSet($app['orm.em']);
