<?php

session_start();

use Cine\App\Controller\MovieController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../.env.php';

if(isset($_GET['route'])) {
    $route = $_GET['route'];
} else {
    $route ='index';
}


$movieController = new MovieController;

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
}elseif ($route === 'showTmdb') {
  $movieController->showTmdb();
}
