<?php

use Ahc\Cli\Application;
use weather\WeatherCommand;

require_once('./vendor/autoload.php');
require_once('./config.php');

$app = new Application('WeatherApp', 'v0.0.1');

$app->add(new WeatherCommand);

$app->handle($_SERVER['argv']);
