<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 13:45
 */

use SimpleFeedback\Comment\CommentDatabase;

class DatabaseTest extends PHPUnit_Framework_TestCase
{
    private $database;

    public function setUp()
    {
        // TODO: Create single testing database and fill it up with data and tear it down afterwards
        $path = dirname(dirname(dirname(__FILE__))) . "/src/data/data.sqlite";
        $connection = new \PDO('sqlite:'.$path);
        $this->database = new CommentDatabase($connection);
    }

    public function testGoodSaveData()
    {
        $goodComment =  \SimpleFeedback\Comment\CommentFactory::createWithIp("Test", "127.0.0.1");
        $this->assertTrue($this->database->saveData($goodComment));
    }



    public function testGetData()
    {
        $expected = \SimpleFeedback\Comment\CommentFactory::createWithIp("Hello", "127.0.0.1");
        $returnedData = $this->database->getData();
        $this->assertEquals($expected, $returnedData[0]);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testBadSaveData()
    {
        \SimpleFeedback\Comment\CommentFactory::createWithIp("", false);
    }
}
