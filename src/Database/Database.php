<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 13:21
 */

namespace SimpleFeedback\Database;


class Database {
    private $connection;

    /**
     * @param $connection \PDO a PDO object to the DB
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param $ipAddress string IP Address
     * @param $commentText string Input text
     * @internal param string $ip IP Address
     * @return bool True if data was saved, False if not.
     */
    public function saveData($ipAddress, $commentText)
    {
        if(empty($ipAddress) || empty($commentText))
        {
            return false;
        }

        $statement = $this->connection->prepare("INSERT INTO comments (IPAddress, commentText)
                                         VALUES (:IpAddress, :commentText)");
        $statement->bindParam(':IpAddress', $ipAddress, \PDO::PARAM_STR);
        $statement->bindParam(':commentText', $commentText, \PDO::PARAM_STR);
        $success = $statement->execute();
        return $success;
    }

    /**
     * @return array The returned row from the database
     */
    public function getData()
    {
        $statement = $this->connection->prepare("SELECT IPAddress, commentText FROM comments ORDER BY rowId ASC;");
        $statement->execute();
        $returnedRow = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $returnedRow;
    }

}
