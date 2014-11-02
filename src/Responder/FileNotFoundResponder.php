<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 16:48
 */

namespace SimpleFeedback\Responder;


class FileNotFoundResponder implements ResponderInterface
{
    public function serve()
    {
        header("HTTP/1.0 404 Not Found");
        echo "File not found!";
    }
}
