<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 13:21
 */

namespace SimpleFeedback;


class Database
{
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
     * Checks whether the comment object is valid (returns false it not) and saves
     * the Object's contents into the database
     * @param Comment $comment a Comment object
     * @return bool True if data was saved, False if not.
     */
    public function saveData(Comment $comment)
    {
        if ($comment->validateObject() === false) {
            return false;
        }
        $sqlQuery = "INSERT INTO comments (IPAddress, commentText) VALUES (:IpAddress, :commentText);";
        $statement = $this->connection->prepare($sqlQuery);
        $ipAddress = $comment->getIpAddress();
        $message = $comment->getMessage();
        $statement->bindParam(':IpAddress', $ipAddress, \PDO::PARAM_STR);
        $statement->bindParam(':commentText', $message, \PDO::PARAM_STR);
        $success = $statement->execute();
        return $success;
    }

    /**
     * @return \SimpleFeedback\Comment Returns a Comment object
     * @see \SimpleFeedback\Comment
     */
    public function getData()
    {
        $statement = $this->connection->prepare("SELECT IPAddress, commentText FROM comments ORDER BY rowId ASC;");
        $statement->execute();
        // TODO: think about using FETCH_OBJECT
        $commentArray = array();

        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $comment = new Comment($row['commentText']);
            $comment->setIp($row['IPAddress']);
            $commentArray[] = $comment;
        }

        return $commentArray;
    }
}
