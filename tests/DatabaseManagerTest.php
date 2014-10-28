<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 14:33
 */

use SimpleFeedback\Database\DatabaseManager;


class DatabaseManagerTest extends PHPUnit_Framework_TestCase {
    private $databaseManager;

    public function setUp()
    {
        $mockDatabase = $this->getMockBuilder("\\SimpleFeedback\\Database\\Database")
            ->disableOriginalConstructor()
            ->getMock();
        $mockDatabase->expects($this->any())
            ->method("saveData")
            ->willReturn(true);
        $mockDatabase->expects($this->any())
            ->method("getData")
            ->willReturn(array(
                array('IPAddress' => '127.0.0.1',
                      'commentText' => 'Test')));

        $this->databaseManager = new DatabaseManager($mockDatabase);
}

    public function testSaveData()
    {


        $inputJSON = '{"commentText": "Test"}';
        $outputJSON = '{"commentText":"Test","IPAddress":"127.0.0.1"}';
        $returnValue = $this->databaseManager->saveJSONData($inputJSON, "127.0.0.1");
        $this->assertEquals($outputJSON, $returnValue);

        $corruptJSON = '{"commentText": ""}';
        $returnValue = $this->databaseManager->saveJSONData($corruptJSON, "127.0.0.1");
        $this->assertFalse($returnValue);

        $corruptJSON = '{"foobar": "Test"}';
        $returnValue = $this->databaseManager->saveJSONData($corruptJSON, "127.0.0.1");
        $this->assertFalse($returnValue);

        $corruptJSON = '{}';
        $returnValue = $this->databaseManager->saveJSONData($corruptJSON, "127.0.0.1");
        $this->assertFalse($returnValue);
    }

    public function testGetData()
    {
        $returnData = $this->databaseManager->getData();
        $expectedData = '[{"IPAddress":"127.0.0.1","commentText":"Test"}]';
        $this->assertEquals($expectedData, $returnData);
    }
}
 