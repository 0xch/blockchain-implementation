<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new \Blockchain\Commands\RunBlockchainCommand());

$application->run();