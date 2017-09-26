<?php

namespace classmanager\core\auth;

use classmanager\core\db\PDOConn;

/**
 * @property PDOConn $pdo
 */
class Authenticator implements AuthIdentity
{

    protected $authTable = 'admin';

    protected $pdo;

    /**
     * Authenticator constructor.
     */
    public function __construct()
    {
        $this->pdo = new PDOConn();
    }

    /**
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login(string $username, string $password)
    {
        $user = $this->pdo->getUser($username, md5($password));
        if ($user['status'] === 1) {
            return true;
        }

        return false;
    }
}