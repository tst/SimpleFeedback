<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 31.10.2014
 * Time: 17:00
 */

use SimpleFeedback\Router;

class RouterTest extends PHPUnit_Framework_TestCase {


    public function testRouting()
    {
        $router = new Router();
        $router->add("default", "default", function() { return "default default";});
        $router->add("GET", "default", function() { return "GET default";});
        $router->add("GET", "param=true", function() { return "GET param=true";});

        $this->assertEquals("default default", $router->route("FOO", "bar"));
        $this->assertEquals("GET default", $router->route("GET", "param=false"));
        $this->assertEquals("GET param=true", $router->route("GET", "param=true"));
        $this->assertEquals("GET default", $router->route("GET", ""));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testNoDefault()
    {
        $router = new Router();
        $router->route("GET", "foo=bar");
    }


}

 