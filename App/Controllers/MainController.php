<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Database;
use App\Core\Render;
use App\Security\SecurityManager;
use App\Security\UserManager;

class MainController extends BaseController
{
    private $tasksController;
    private $userController;

    public function __construct(Render $render, SecurityManager $securityManager, Database $database, UserManager $userManager)
    {
        parent::__construct($render, $securityManager, $database, $userManager);
    }

    public function getTasksController(): TasksController
    {
        if ($this->tasksController === null) {
            $this->tasksController = new TasksController(
                $this->render,
                $this->securityManager,
                $this->database,
                $this->userManager
            );
        }

        return $this->tasksController;
    }

    public function getUsersController(): UsersController
    {
        if ($this->userController === null) {
            $this->userController = new UsersController(
                $this->render,
                $this->userManager
            );
        }

        return $this->userController;
    }
}
