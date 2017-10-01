<?php

namespace classmanager\core\auth;

use classmanager\core\db\persistence\Persistence;
use PDO;

class Authenticator implements AuthIdentity
{
    const ACTIVE_STATUS = 1;

    /**
     * @var Persistence
     */
    private $db;

    /** @var PDO $pdo */
    private $pdo;

    /**
     * Authenticator constructor.
     * @param Persistence $db
     */
    public function __construct(Persistence $db)
    {
        $this->db = $db;

        $this->pdo = $this->db->getPdo();
    }

    /**
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login(string $username, string $password)
    {
        $user = $this->getUserByCredentials($username, md5($password));
        if ($user['status'] === self::ACTIVE_STATUS) {
            $_SESSION['adminId'] = $user['adminId'];
            $_SESSION['logged'] = true;

            header("location:home.php?user=" .
                base64_encode($username) .
                "&name=" . base64_encode($user['name']) .
                "&adminstatus=" . base64_encode($user['status']));
        }

        return 'Login failed!';
    }

    private function getUserByCredentials($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `admin` WHERE `username` = :username AND `password` = :pword");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pword', $password);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function logout()
    {
        unset($_SESSION['adminId']);
        unset($_SESSION['logged']);

        header("location:index.php?out=You have logged out successfully!");
    }
}