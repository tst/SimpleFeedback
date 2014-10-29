<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 29.10.2014
 * Time: 10:49
 */

use SimpleFeedback\Comment;

class CommentTest extends PHPUnit_Framework_TestCase
{


    /**
     * @expectedException \BadMethodCallException
     */
    public function testException()
    {
        new Comment("");
    }

    public function testValidation()
    {
        $comment = new Comment("Test");
        $this->assertFalse($comment->validateObject());

        $comment->setIp("127.0.0.1");
        $this->assertTrue($comment->validateObject());

    }

    public function testGetters()
    {
        $comment = new Comment("Test");
        $this->assertEquals("Test", $comment->getMessage());

        $comment->setIp("127.0.0.1");
        $this->assertEquals("127.0.0.1", $comment->getIpAddress());
    }
}
