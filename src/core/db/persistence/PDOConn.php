<?php

namespace classmanager\core\db\persistence;

use PDO;

class PDOConn
{
    /** @var PDO $pdo */
    private $pdo;

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

    public function getPdo()
    {
        return $this->pdo;
    }
}
