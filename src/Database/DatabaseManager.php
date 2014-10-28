<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 14:31
 */

namespace SimpleFeedback\Database;


class DatabaseManager {
    private $database;

    /**
     * @param Database $database An database object
     * @see SimpleFeedback\Database;
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Takes an input in JSON format and an IP Address and returns the
     * new output as JSON or false if it fails.
     * @param $inputJSON string in JSON format
     * @param $ipAddress string IP Address
     * @return bool|string either the JSON output or false.
     */
    public function saveJSONData($inputJSON, $ipAddress)
    {
        // TODO: Shouldn't do decoding, this should happen in Responders, maybe create an object!
        $inputArray = json_decode($inputJSON, true);
        $outputArray = $inputArray;
        $outputArray['IPAddress'] = $ipAddress;
        $outputJSON = json_encode($outputArray);


        if(!empty($inputArray['commentText']) === true) {
            $success = $this->database->saveData($ipAddress, $inputArray['commentText']);
            return $success === true ? $outputJSON : false;
        } else {
            return false;
        }
    }

    /**
     * Gets the data from the database and returns it in JSON
     * @return string data in JSON format
     */
    public function getData()
    {
        // TODO: No decoding here
        $arrayData = $this->database->getData();
        $outputJSON = json_encode($arrayData);
        return $outputJSON;

    }
} 