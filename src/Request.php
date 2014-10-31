<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 31.10.2014
 * Time: 16:39
 */

namespace SimpleFeedback;


class Request 
{
    protected $request;

    public function __construct($request) {
        $this->request = $request;

    }

    /**
     * @return string The IP Address which made the request
     */
    public function getIpAddress() {
        return $this->request['REMOTE_ADDR'];
    }

    /**
     * @return string The request method (GET, POST, etc.)
     */
    public function getRequestMethod() {
        return $this->request['REQUEST_METHOD'];
    }

    /**
     * @return string Returns the query string
     */
    public function getQuery() {
        return $this->request['QUERY_STRING'];
    }

} 