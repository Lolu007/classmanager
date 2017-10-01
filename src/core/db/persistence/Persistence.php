<?php

namespace classmanager\core\db\persistence;

interface Persistence
{
    public function retrieve(string $table, string $whereKey, int $id, $columns = []);

    public function executeQuery(string $query);

    public function countRows(string $query);

    public function getPdo();
}