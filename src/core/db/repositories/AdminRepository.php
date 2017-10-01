<?php

namespace classmanager\core\db\repositories;

class AdminRepository extends AbstractRepository implements Repository
{
    protected $table = 'admin';

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->db->retrieve($this->table, 'adminId', $id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data)
    {
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
    }
}