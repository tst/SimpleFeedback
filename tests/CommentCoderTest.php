<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 29.10.2014
 * Time: 11:44
 */

use SimpleFeedback\CommentCoder;

class CommentCoderTest extends PHPUnit_Framework_TestCase
{

    public function testEncoder()
    {
        $comment = \SimpleFeedback\CommentFactory::createWithIp("Test", "127.0.0.1");
        $expected = '{"commentMessage":"Test","ipAddress":"127.0.0.1"}';
        $this->assertEquals($expected, CommentCoder::encode($comment));
    }

    public function testDecoder()
    {
        $json = '{"commentMessage":"Test","ipAddress":"127.0.0.1"}';
        $expected = \SimpleFeedback\CommentFactory::createWithIp("Test", "127.0.0.1");

        $comment = CommentCoder::decode($json);
        $this->assertEquals($expected, $comment);

        $json = '{"commentMessage":"Test"}';
        $expected = \SimpleFeedback\CommentFactory::createMinimal("Test");

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

    public function testEncoderArray()
    {
        $comments = array(
            \SimpleFeedback\CommentFactory::createWithIp("Hi", "127.0.0.1"),
            \SimpleFeedback\CommentFactory::createWithIp("Hello", "127.0.0.2")
            );
        $expected = '[{"commentMessage":"Hi","ipAddress":"127.0.0.1"},'
                . '{"commentMessage":"Hello","ipAddress":"127.0.0.2"}]';

        $json = CommentCoder::encodeArray($comments);
        $this->assertEquals($expected, $json);
    }
}
