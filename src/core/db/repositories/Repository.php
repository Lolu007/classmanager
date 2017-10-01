<?php

namespace classmanager\core\db\repositories;

interface Repository
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param $data
     * @return mixed
     */
    public function save($data);

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data);
}