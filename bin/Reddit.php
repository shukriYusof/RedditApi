#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Reddit\Command\RedditSearchCommand;
use Reddit\Service\RedditService;
use Reddit\Service\PostFilterService;
use Reddit\Service\TableFormatter;
use GuzzleHttp\Client;

// Create a new Symfony Console application
$application = new Application();

// Initialize the services
$client = new Client();
$redditService = new RedditService($client); // Ensure this implements RedditServiceInterface
$postFilterService = new PostFilterService();
$tableFormatter = new TableFormatter();

// Register the command and inject dependencies
$application->add(new RedditSearchCommand(
    $redditService,
    $postFilterService,
    $tableFormatter
));

// Run the application
$application->run();
