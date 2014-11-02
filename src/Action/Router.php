<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 31.10.2014
 * Time: 16:54
 */

namespace SimpleFeedback\Action;


class Router
{
    protected $routes;

    /**
     * Is used to add routings
     * @param string   $method A method, e.g. "POST" or "GET"
     * @param string   $query  A query string, e.g. "foo=bar"
     * @param callable $function A function which is called when routing matches
     */
    public function add($method, $query, callable $function)
    {
        $this->routes[$method][$query] = $function;
    }

    /**
     * @param $method string A method, e.g. "GET" or "POST"
     * @param $query string A query string, e.g. "foo=bar"
     * @return mixed Returns the value of the function used in add(), may return nothing
     */
    public function route($method, $query)
    {
        if (isset($this->routes[$method][$query])) {
            return $this->routes[$method][$query]();
        }

        if (isset($this->routes[$method]["default"])) {
            return $this->routes[$method]["default"]();
        }

        if (!isset($this->routes["default"]["default"])) {
            throw new \OutOfBoundsException("Please provide a world wide default route!");
        }

        return $this->routes["default"]["default"]();


    }
}
