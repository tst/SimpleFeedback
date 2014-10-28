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
        $connection = new \PDO('sqlite:../src/data.db');
        $this->database = new Database($connection);
    }


    public function testSaveData()
    {
        $this->assertTrue($this->database->saveData("127.0.0.1", "Test"));
        $this->assertFalse($this->database->saveData(false, false));
        $this->assertFalse($this->database->saveData(false, "Test"));
        $this->assertFalse($this->database->saveData("127.0.0.1", ""));
    }

    public function testGetData()
    {
        $expected = array('IPAddress' => '127.0.0.1',
                          'commentText' => 'Test');
        $returnedData = $this->database->getData();
        $this->assertEquals($returnedData[0], $expected);
    }

}
 