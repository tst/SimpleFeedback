<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 17:06
 */

namespace SimpleFeedback\Responder;


class PostFailureResponder implements ResponderInterface
{
    public function serve()
    {
        header("HTTP/1.1 400 Bad Request");
        exit;
    }
}
