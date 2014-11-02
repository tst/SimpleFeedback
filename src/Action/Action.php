<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 16:27
 */

namespace SimpleFeedback\Action;

use SimpleFeedback\Comment\CommentDatabase;
use SimpleFeedback\Comment\CommentCoder;
use SimpleFeedback\Responder;

class Action
{
    private $database;
    private $request;
    private $router;

    public function __construct(CommentDatabase $database, Request $request, Router $router)
    {
        $this->database = $database;
        $this->request = $request;
        $this->router = $router;
    }


    /**
     * Does the routing. Here you can define what handlers should be called.
     */
    public function handleRequest()
    {
        $method = $this->request->getRequestMethod();
        $query = $this->request->getQuery();

        $this->router->add("default", "default", function () {
            $this->handle404();
        });

        $this->router->add("GET", "action=show", function () {
            $this->handleShow();
        });
        $this->router->add("POST", "default", function () {
            $input = file_get_contents("php://input");
            $this->handlePost($input);
        });

        $this->router->route($method, $query);
    }

    protected function handleShow()
    {
        $responder = new Responder\ShowResponder();
        $outputData = $this->database->getData();
        $responder->setOutput($outputData);
        $responder->serve();
    }

    protected function handlePost($input)
    {
        $comment = null;
        try {
            $comment = CommentCoder::decode($input);
            $comment->setIp($this->request->getIpAddress());
        } catch (\InvalidArgumentException $e) {
            $responder = new Responder\PostFailureResponder();
        } catch(\BadMethodCallException $e) {
            $responder = new Responder\PostFailureResponder();
        }

        if (!isset($responder)) {
            $success = $this->database->saveData($comment);

            if ($success === false) {
                $responder = new Responder\PostFailureResponder();
            } else {
                $responder = new Responder\PostSuccessResponder();
                $jsonOutput = CommentCoder::encode($comment);
                $responder->setOutput($jsonOutput);
            }
        }
        $responder->serve();
    }

    protected function handle404()
    {
        $responder = new Responder\FileNotFoundResponder();
        $responder->serve();
    }
}
