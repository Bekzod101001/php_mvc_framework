<?php


use app\controllers\ArticleController;
use app\controllers\AuthController;
use app\controllers\CommentController;
use app\controllers\LoginController;
use app\controllers\PublicController;
use app\controllers\RegisterController;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
$app = new app\core\Application(dirname(__DIR__));

$app->router->get('/', [PublicController::class, 'home']);
$app->router->get('/auth/me', [AuthController::class, 'showMe']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/login', [LoginController::class, 'show']);
$app->router->post('/login', [LoginController::class, 'handle']);

$app->router->get('/register', [RegisterController::class, 'show']);
$app->router->post('/register', [RegisterController::class, 'handle']);

$app->router->get('/articles', [ArticleController::class, 'index']);
$app->router->post('/comment', [CommentController::class, 'store']);


$app->run();