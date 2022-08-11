<?php


require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

$app = new app\core\Application(__DIR__);
$app->database->runMigrations();