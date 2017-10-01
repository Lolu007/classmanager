<?php

namespace classmanager\core\db\repositories;

use classmanager\core\db\persistence\Persistence;

class AbstractRepository
{
    /**
     * @var Persistence $db
     */
    protected $db;

    /**
     * AbstractRepository constructor.
     * @param Persistence $db
     */
    public function __construct(Persistence $db)
    {
        $this->db = $db;
    }
}