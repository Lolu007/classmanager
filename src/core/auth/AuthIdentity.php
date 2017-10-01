<?php

namespace ClassManager\core\auth;

/**
 * Interface AuthIdentity
 * @package ClassManager\core\auth
 */
interface AuthIdentity
{
    public function login(string $username, string $password);

    public function logout();
}