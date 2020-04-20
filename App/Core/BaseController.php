<?php
namespace App\Core;

use App\Security\SecurityManager;
use App\Security\UserManager;

abstract class BaseController
{
    protected $render;
    protected $securityManager;
    protected $database;
    protected $userManager;

    public function __construct(Render $render, SecurityManager $securityManager = null, Database $database = null, UserManager $userManager = null)
    {
        $this->render = $render;
        $this->securityManager = $securityManager;
        $this->database = $database;
        $this->userManager = $userManager;
    }

    protected function redirectToIndex(): void
    {
        header('Location: ' . ROOT_PATH);
    }
}
