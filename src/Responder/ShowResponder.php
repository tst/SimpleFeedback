<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 16:56
 */

namespace SimpleFeedback\Responder;


use SimpleFeedback\CommentCoder;

class ShowResponder {
    private $output;
    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function serve()
    {
        header("Content-Type: application/json");
        $comments = array_map(function($x){return CommentCoder::encode($x);}, $this->output);
        echo json_encode($comments);
    }
} 