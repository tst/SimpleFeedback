<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 30.10.2014
 * Time: 10:42
 */

namespace SimpleFeedback;


class CommentFactory
{
    /**
     * @param $message string A message
     * @return Comment A new instance
     */
    public static function createMinimal($message)
    {
        $instance = new Comment($message);

        return $instance;
    }

    /**
     * @param $message string A message
     * @param $ipAddress string An ip address
     * @return Comment A new instance
     */
    public static function createWithIp($message, $ipAddress)
    {
        $instance = static::createMinimal($message);
        $instance->setIp($ipAddress);

        return $instance;
    }
}
