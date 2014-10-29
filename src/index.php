<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 12:00
 */

namespace SimpleFeedback;

require '../vendor/autoload.php';

$action = new Action($_SERVER);
$action->handleRequest();
