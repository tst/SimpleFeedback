<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 12:00
 */

namespace SimpleFeedback;

require '../vendor/autoload.php';

$pdo = new \PDO('sqlite:data.db');
$database = new Database($pdo);
$request = new Request($_SERVER);
$router = new Router();

$action = new Action($database, $request, $router);
$action->handleRequest();
