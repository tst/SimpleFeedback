<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 29.10.2014
 * Time: 11:44
 */

use SimpleFeedback\CommentCoder;


class CommentCoderTest extends PHPUnit_Framework_TestCase {


    public function testEncoder()
    {
        $comment = new \SimpleFeedback\Comment("Test");
        $comment->setIp("127.0.0.1");
        $expected = '{"commentMessage":"Test","ipAddress":"127.0.0.1"}';
        $this->assertEquals($expected, CommentCoder::encode($comment));
    }

    public function testDecoder()
    {
        $json = '{"commentMessage":"Test","ipAddress":"127.0.0.1"}';
        $expected = new \SimpleFeedback\Comment("Test");
        $expected->setIp("127.0.0.1");

        $comment = CommentCoder::decode($json);
        $this->assertEquals($expected, $comment);

        $json = '{"commentMessage":"Test"}';
        $expected = new \SimpleFeedback\Comment("Test");

        $comment = CommentCoder::decode($json);
        $this->assertEquals($expected, $comment);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDecoderException()
    {
        CommentCoder::decode("");
    }


}
 