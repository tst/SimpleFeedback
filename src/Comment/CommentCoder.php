<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 29.10.2014
 * Time: 11:38
 */

namespace SimpleFeedback\Comment;


/**
 * Class CommentCoder
 * Takes care of encoding and decoding a comment from and to JSON
 * @package SimpleFeedback
 */
class CommentCoder
{

    /**
     * Used to convert an Comment Object to JSON
     * @param Comment $comment A comment object
     * @return string Returns object as JSON
     */
    public static function encode(Comment $comment)
    {
        $inputArray = array('commentMessage' => $comment->getMessage(),
                            'ipAddress' => $comment->getIpAddress());
        $jsonOutput = json_encode($inputArray);
        return $jsonOutput;
    }

    /** Is used to encode an array of Comment objects
     * @param Comment[] $comments An array of comment objects
     * @return string All objects encoded in JSON
     */
    public static function encodeArray(array $comments)
    {
        $commentAsArray = array();
        foreach ($comments as $comment) {
            $commentField = array('commentMessage' => $comment->getMessage(),
                'ipAddress' => $comment->getIpAddress());
            $commentAsArray[] = $commentField;
        }
        $jsonOutput = json_encode($commentAsArray);
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

        if (!isset($inputArray['commentMessage'])) {
            throw new \InvalidArgumentException("The variable commentMessage is missing!");
        }


        if (isset($inputArray['ipAddress'])) {
            $comment = CommentFactory::createWithIp($inputArray['commentMessage'], $inputArray['ipAddress']);
        } else {
            $comment = CommentFactory::createMinimal($inputArray['commentMessage']);
        }

        return $comment;
    }
}
