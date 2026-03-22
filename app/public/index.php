<?php
session_start();

use Cine\App\Controller\MovieController;
use Cine\App\Controller\AuthController;
use Cine\App\Controller\UserController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../.env.php';
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST']);

$route = $_GET['route'] ?? 'index';

// Routes publiques
if ($route === 'login') {
    $authController = new AuthController();
    $authController->login();
    exit;
}

if ($route === 'logout') {
    $authController = new AuthController();
    $authController->logout();
    exit;
}

if ($route === 'register') {
    $authController = new AuthController();
    $authController->register();
    exit;
}


// Protection globale — redirige vers login si pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ?route=login');
    exit;
}

if ($route === 'searchApi') {
    $movieController = new MovieController();
    $movieController->searchApi();
    exit;
}

if ($route === 'addFromTmdbApi') {
    $movieController = new MovieController();
    $movieController->addFromTmdbApi();
    exit;
}

if ($route === 'filmsApi') {
    $movieController = new MovieController();
    $movieController->filmsApi();
    exit;
}


// Routes protégées
$movieController = new MovieController();

if ($route === 'index') {
    $movieController->index();
} elseif ($route === 'show') {
    $movieController->show();
} elseif ($route === 'update') {
    $movieController->update();
} elseif ($route === 'delete') {
    $movieController->delete();
} elseif ($route === 'search') {
    $movieController->search();
} elseif ($route === 'showTmdb') {
    $movieController->showTmdb();
} elseif ($route === 'addFromTmdb') {
    $movieController->addFromTmdb();
} elseif ($route === 'genres') {
    $movieController->genres();
} elseif ($route === 'genreCreate') {
    $movieController->genreCreate();
} elseif ($route === 'genreUpdate') {
    $movieController->genreUpdate();
} elseif ($route === 'genreDelete') {
    $movieController->genreDelete();
} elseif ($route === 'profile') {
    $userController = new UserController();
    $userController->profile();
} elseif ($route === 'deleteAccount') {
    $userController = new UserController();
    $userController->deleteAccount();
}