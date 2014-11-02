<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 30.10.2014
 * Time: 10:52
 */

use SimpleFeedback\Comment;

class CommentFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \BadMethodCallException
     */
    public function testCreateMinimalException()
    {
        \SimpleFeedback\Comment\CommentFactory::createMinimal("");
    }

    public function testCreateMinimal()
    {
        $comment = \SimpleFeedback\Comment\CommentFactory::createMinimal("Test");
        $this->assertEquals("Test", $comment->getMessage());
        $this->assertFalse($comment->validateObject());
    }

    public function testCreateWithIp()
    {
        $comment = \SimpleFeedback\Comment\CommentFactory::createWithIp("Test", "127.0.0.1");
        $this->assertEquals("127.0.0.1", $comment->getIpAddress());
        $this->assertEquals("Test", $comment->getMessage());
        $this->assertTrue($comment->validateObject());
    }

    public function testXSS()
    {
        $comment = \SimpleFeedback\Comment\CommentFactory::createMinimal("<script>alert('\"')");
        $expected = '&lt;script&gt;alert(&#039;&quot;&#039;)';
        $this->assertEquals($expected, $comment->getMessage());

        $comment = \SimpleFeedback\Comment\CommentFactory::createWithIp("<script>alert('\"')", "127.0.0.1");
        $this->assertEquals($expected, $comment->getMessage());
    }
}
