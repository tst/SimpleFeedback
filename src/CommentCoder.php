<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 29.10.2014
 * Time: 11:38
 */

namespace SimpleFeedback;


/**
 * Class CommentCoder
 * Takes care of encoding and decoding a comment from and to JSON
 * @package SimpleFeedback
 */
class CommentCoder {

    /**
     * Used to convert an Comment Object to JSON
     * @param Comment $comment A comment object
     * @return string Returns object as JSON
     */
    public static function encode(Comment $comment)
    {
        $inputArray = Array('commentMessage' => $comment->getMessage(),
                            'ipAddress' => $comment->getIpAddress());
        $jsonOutput = json_encode($inputArray);
        return $jsonOutput;
    }

    /**
     * Used to decode a JSON string to an Comment object
     * @param $inputJSON string JSON representation of a Comment object
     * @return Comment Returns a Comment object from the JSON input
     */
    public static function decode($inputJSON)
    {
        $inputArray = json_decode($inputJSON, true);

        if(!isset($inputArray['commentMessage'])) {
            throw new \InvalidArgumentException("The variable commentMessage is missing!");
        }

        $comment = new Comment($inputArray['commentMessage']);

        if(isset($inputArray['ipAddress'])) {
            $comment->setIp($inputArray['ipAddress']);
        }
        return $comment;
    }

}