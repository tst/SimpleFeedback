<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 28.10.2014
 * Time: 16:50
 */

namespace SimpleFeedback\Database;


class DatabaseManagerFactory {
    protected $databaseManager;
    public function __construct(\PDO $pdo) {
        $connection = $pdo;
        $database = new Database($connection);
        $this->databaseManager = new DatabaseManager($database);
    }

    public function getDatabaseManager()
    {
        return $this->databaseManager;
    }

} 