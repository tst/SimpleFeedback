<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 12:00
 */

namespace SimpleFeedback;

require '../vendor/autoload.php';


use SimpleFeedback\Action;
use SimpleFeedback\Comment\CommentDatabase;

// TODO: DI Container?

$pdo = new \PDO('sqlite:data/data.sqlite');
$database = new CommentDatabase($pdo);
$request = new Action\Request($_SERVER);
$router = new Action\Router();

$action = new Action\Action($database, $request, $router);
$action->handleRequest();
