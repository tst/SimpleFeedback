<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 29.10.2014
 * Time: 11:44
 */

use SimpleFeedback\Comment\CommentCoder;
use SimpleFeedback\Comment\CommentFactory;

class CommentCoderTest extends PHPUnit_Framework_TestCase
{

    public function testEncoder()
    {
        $comment = CommentFactory::createWithIp("Test", "127.0.0.1");
        $expected = '{"commentMessage":"Test","ipAddress":"127.0.0.1"}';
        $this->assertEquals($expected, CommentCoder::encode($comment));
    }

    public function testDecoder()
    {
        $json = '{"commentMessage":"Test","ipAddress":"127.0.0.1"}';
        $expected = CommentFactory::createWithIp("Test", "127.0.0.1");

        $comment = CommentCoder::decode($json);
        $this->assertEquals($expected, $comment);

        $json = '{"commentMessage":"Test"}';
        $expected = CommentFactory::createMinimal("Test");

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
            CommentFactory::createWithIp("Hi", "127.0.0.1"),
            CommentFactory::createWithIp("Hello", "127.0.0.2")
            );
        $expected = '[{"commentMessage":"Hi","ipAddress":"127.0.0.1"},'
                . '{"commentMessage":"Hello","ipAddress":"127.0.0.2"}]';

        $json = CommentCoder::encodeArray($comments);
        $this->assertEquals($expected, $json);
    }


    /**
     * @expectedException \BadMethodCAllException
     */
    public function testEmptyMessage()
    {
        CommentCoder::decode('{"commentMessage":""}');
    }
}
