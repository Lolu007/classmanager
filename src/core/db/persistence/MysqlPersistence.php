<?php

namespace classmanager\core\db\persistence;

use PDO;
use PDOStatement;

class MysqlPersistence implements Persistence
{
    /**
     * @var PDOConn
     */
    private $pdoConn;

    /**
     * MysqlPersistence constructor.
     */
    public function __construct()
    {
        $this->pdoConn = new PDOConn();
    }

    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdoConn->getPdo();
    }

    /**
     * @param string $table
     * @param string $whereKey
     * @param int $id
     * @param array $columns
     * @return mixed
     * @internal param array $where
     */
    public function retrieve(string $table, string $whereKey, int $id, $columns = [])
    {
        /** @var PDOStatement $statement */
        $statement = $this->pdoConn->getPdo()->prepare("SELECT * FROM {$table} WHERE {$whereKey} = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @deprecated - Not safe
     *
     * @param string $query
     */
    public function executeQuery(string $query)
    {
        $this->pdoConn->getPdo()->exec($query);
    }

    /**
     * @deprecated
     *
     * @param $query
     * @return int
     */
    public function countRows(string $query)
    {
        /** @var PDOStatement $result */
        $statement = $this->pdoConn->getPdo()->query($query);

        return $statement->rowCount();
    }
}