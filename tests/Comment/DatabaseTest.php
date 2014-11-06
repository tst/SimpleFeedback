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
    private static $connection;

    public static function setUpBeforeClass()
    {
        $pathToSchema = dirname(dirname(dirname(__FILE__))) . "/src/data/schema.sql";
        $SQLSchema = file_get_contents($pathToSchema);

        $connection = new \PDO('sqlite::memory:');
        $connection->exec($SQLSchema);

        $connection->exec("INSERT INTO comments (IPAddress, commentText) VALUES ('127.0.0.1', 'First')");

        self::$connection = $connection;
    }


    public function setUp()
    {
        $this->database = new CommentDatabase(self::$connection);
    }

    public function testGoodSaveData()
    {
        $goodComment =  \SimpleFeedback\Comment\CommentFactory::createWithIp("Test", "127.0.0.1");
        $this->assertTrue($this->database->saveData($goodComment));
    }



    public function testGetData()
    {
        $expected = \SimpleFeedback\Comment\CommentFactory::createWithIp("First", "127.0.0.1");
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
