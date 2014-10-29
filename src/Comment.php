<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 29.10.2014
 * Time: 10:44
 */

namespace SimpleFeedback;


class Comment {
    protected $message;
    protected $ipAddress;

    /**
     * @param $message string The main message
     */
    public function __construct($message)
    {
        if(empty($message)) {
            throw new \BadMethodCallException;
        }
        $this->message = $message;
    }

    /**
     * This method has to be called to get a valid object!
     * @param $ipAddress string IP Address
     */
    public function setIp($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * Checks if both the ipAddress and message aren't empty
     * @return bool Returns true if the ipAddress and message aren't empty
     */
    public function validateObject()
    {
        return (!empty($this->ipAddress) && !empty($this->message));
    }

    /**
     * @return string Returns the IpAddress
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
       * @return string Returns the message
       */
    public function getMessage()
    {
        return $this->message;
    }

} 