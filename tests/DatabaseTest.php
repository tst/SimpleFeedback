<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 13:45
 */

use SimpleFeedback\Database;

class DatabaseTest extends PHPUnit_Framework_TestCase
{
    private $database;

    public function setUp()
    {
        $path = dirname(dirname(__FILE__)) . "/src/data.db";
        $connection = new \PDO('sqlite:'.$path);
        $this->database = new Database($connection);
    }

    public function testGoodSaveData()
    {
        $goodComment =  \SimpleFeedback\CommentFactory::createWithIp("Test", "127.0.0.1");
        $this->assertTrue($this->database->saveData($goodComment));
    }



    public function testGetData()
    {
        $expected = \SimpleFeedback\CommentFactory::createWithIp("Hello", "127.0.0.1");
        $returnedData = $this->database->getData();
        $this->assertEquals($expected, $returnedData[0]);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testBadSaveData()
    {
        \SimpleFeedback\CommentFactory::createWithIp("", false);
    }
}
