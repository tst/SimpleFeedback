<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 16:27
 */

namespace SimpleFeedback;


class Action {
    private $request;
    private $ipAddress;
    private $databaseManager;

    public function __construct($request)
    {
        $this->request = $request;
        $pdo = new \PDO('sqlite:data.db');
        $databaseManagerFactory = new DatabaseManagerFactory($pdo);
        $this->databaseManager = $databaseManagerFactory->getDatabaseManager();
    }



    public function handleRequest()
    {
        $this->ipAddress = $this->request['REMOTE_ADDR'];
        $method = $this->request['REQUEST_METHOD'];

        parse_str($this->request['QUERY_STRING'], $parsedString);

        if($method === "GET") {
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
        $responder = new ShowResponder();
        $outputData = $this->databaseManager->getData();
        $responder->setOutput($outputData);
        $responder->serve();

    }

    protected function handlePost($input)
    {

        $success = $this->databaseManager->saveJSONData($input, $this->ipAddress);
        if($success === false) {
            $responder = new PostFailureResponder();
        } else {
            $responder = new PostSuccessResponder();
            $responder->setOutput($success);
        }
        $responder->serve();
    }

    protected function handle404()
    {
        $responder = new FileNotFoundResponder();
        $responder->serve();
    }
} 