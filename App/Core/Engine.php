<?php
namespace App\Core;

use App\Security\SecurityManager;
use App\Security\SessionManager;
use App\Security\UserManager;
use App\Controllers\MainController;

class Engine {
    private static $mainController = null;
    private static $render = null;
    private static $securityManager = null;
    private static $database = null;
    private static $userManager = null;
    private static $sessionManager = null;

    public static function getMainController(): MainController
    {
        if (static::$mainController === null) {
            static::$mainController = new MainController(
                static::getRender(),
                static::getSecurityManager(),
                static::getDatabase(),
                static::getUserManager()
            );
        }

        return static::$mainController;
    }

    public static function getSecurityManager(): SecurityManager {
        if (static::$securityManager === null) {
            static::$securityManager = new SecurityManager(
                static::getUserManager()
            );
        }

        return static::$securityManager;
    }

    public static function getSessionManager(): SessionManager {
        if (static::$sessionManager === null) {
            static::$sessionManager = new SessionManager();
        }

        return static::$sessionManager;
    }

    public static function getRender(): Render {
        if (static::$render === null) {
            static::$render = new Render();
        }

        return static::$render;
    }

    public static function getUserManager(): UserManager {
        if (static::$userManager === null) {
            static::$userManager = new UserManager(
                static::getSessionManager()
            );
        }

        return static::$userManager;
    }

    public static function getDatabase(): Database {
        if (static::$database === null) {
            static::$database = new Database();
        }

        return static::$database;
    }
}
