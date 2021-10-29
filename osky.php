<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Osky\Main;

$app = new Application('Reddit Search', '0.1.0');
$app->add(new Main());
$app -> run();