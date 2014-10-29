<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 16:27
 */

namespace SimpleFeedback;

class Action
{
    private $database;
    private $request;
    private $ipAddress;

    public function __construct(Database $database, $request)
    {
        $this->database = $database;
        $this->request = $request;
    }


    /**
     * Does the routing. Here you can define what handlers should be called.
     */
    public function handleRequest()
    {
        // TODO: Fix this mess
        $this->ipAddress = $this->request['REMOTE_ADDR'];
        $method = $this->request['REQUEST_METHOD'];

        parse_str($this->request['QUERY_STRING'], $parsedString);

        if ($method === "GET") {
            if (!isset($parsedString['action'])) {
                $this->handle404();
            } else {
                switch ($parsedString['action']) {
                    case 'show':
                        $this->handleShow();
                        break;
                    default:
                        $this->handle404();
                        break;
                }
            }
        } elseif ($method === "POST") {
            $input = file_get_contents('php://input');
            $this->handlePost($input);
        } else {
            $this->handle404();
        }
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
            $comment->setIp($this->ipAddress);
        } catch (\InvalidArgumentException $e) {
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
