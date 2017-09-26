<?php

namespace classmanager\core\db;

use PDO;

class PDOConn
{
    /** @var PDO $pdo */
    protected $pdo;

    public function __construct()
    {
        $option = array ();
        $option['host'] = 'localhost';
        $option['user'] = 'homestead';
        $option['password'] = 'secret';
        $option['database'] = 'classmanager';

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO(
            'mysql:host=' . $option['host'] . ';dbname=' . $option['database'] . ';charset=utf8mb4',
            $option['user'], $option['password'], $opt);

    }

    public function executeQuery($query)
    {
        return $this->pdo->exec($query);
    }

    public function fetchData($query)
    {
        var_dump($query);die();
        return $this->pdo->exec($query);
    }

    public function getNumOfRows($query)
    {
        /** @var PDOStatement $result */
        $statement = $this->pdo->query($query);

        return $statement->rowCount();
    }

    public function getUser($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `admin` WHERE `username` = :username AND `password` = :pword");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pword', $password);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
