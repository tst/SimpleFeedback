<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 17:06
 */

namespace SimpleFeedback\Responder;


class PostSuccessResponder {
    private $output;
    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function serve()
    {
        header("Content-Type: application/json");
        echo $this->output;
    }

} 