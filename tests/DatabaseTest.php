<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 13:45
 */

use SimpleFeedback\Database;

class DatabaseTest extends PHPUnit_Framework_TestCase {
    private $database;

    public function setUp()
    {
        $path = dirname(dirname(__FILE__)) . "/src/data.db";
        $connection = new \PDO('sqlite:'.$path);
        $this->database = new Database($connection);
    }

    private function generateCommentObjects($message, $ipAddress)
    {
        $comment = new \SimpleFeedback\Comment($message);
        $comment->setIp($ipAddress);
        return $comment;
    }

    public function testGoodSaveData()
    {
        $goodComment = $this->generateCommentObjects("Test", "127.0.0.1");
        $this->assertTrue($this->database->saveData($goodComment));
    }



    public function testGetData()
    {
        $expected = $this->generateCommentObjects("Hello", "127.0.0.1");
        $returnedData = $this->database->getData();
        $this->assertEquals($expected, $returnedData[0]);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testBadSaveData()
    {
        $this->generateCommentObjects("", false);
    }

}
 