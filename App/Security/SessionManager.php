<?php
namespace App\Security;

class SessionManager
{
    public function __construct()
    {
        if(!isset($_SESSION)) {
            session_start();
        }
    }

    public static function setCommonSession(): void
    {
        $_SESSION['id'] = null;
        $_SESSION['name'] = 'Anonymous';
        $_SESSION['role'] = 'common';
    }

    public function setAdminSession(): void
    {
        $_SESSION['id'] = 1;
        $_SESSION['name'] = 'admin';
        $_SESSION['role'] = 'admin';
    }

    public function clearSession(): void
    {
        $this->setCommonSession();
    }
}
