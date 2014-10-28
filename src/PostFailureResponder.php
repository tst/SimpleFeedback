<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 17:06
 */

namespace SimpleFeedback;


class PostFailureResponder {
    public function serve()
    {
        header("400 Bad Request");
        exit;
    }
} 