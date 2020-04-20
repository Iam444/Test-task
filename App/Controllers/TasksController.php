<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Database;
use App\Core\Engine;
use App\Models\TasksModel;
use App\Security\SecurityManager;
use App\Core\Render;
use App\Security\SessionManager;
use App\Security\UserManager;

class TasksController extends BaseController
{
    private $tasksModel;

    public function __construct(Render $render, SecurityManager $securityManager, Database $database, UserManager $userManager)
    {
        $this->tasksModel = new TasksModel($database);

        parent::__construct($render, $securityManager, null, $userManager);
    }

    public function index()
    {
        $isAdmin = $this->userManager->checkIfUserIsAdmin();
        if (!$isAdmin) {
            SessionManager::setCommonSession();
        }

        return $this->render->render('common/index.html', [
            'msg' => $this->tasksModel->getMessage(),
            'isAdmin' => $isAdmin,
            'allTasks' => $this->tasksModel->getTasks(),
            'sortDirection' => $this->tasksModel->getSortDirection(),
            'sortBy' => $this->tasksModel->getSortBy(),
            'user' => $this->userManager->getUser()
        ]);
    }

    public function createTask()
    {
        $this->tasksModel->createTask();
        $this->tasksModel->setMessage('Задача успешно добавлена');

        return $this->index();
    }

    public function editTask()
    {
        $this->securityManager->allowAccessToAdmin();

        if ($this->securityManager->canUserAccessPage()) {
            $this->tasksModel->editTask();

            $this->redirectToIndex();
        } else {
            return Engine::getMainController()->getUsersController()->index('Ошибка авторизации. Войдите в профиль администратора для редактирования записей.');
        }
    }

    public function changeStatus()
    {
        $this->securityManager->denyAccess();

        $this->securityManager->allowAccessToAdmin();
        if ($this->securityManager->canUserAccessPage()) {
            $this->tasksModel->changeStatus();

            $this->redirectToIndex();
        } else {
            return Engine::getMainController()->getUsersController()->index();
        }
    }
}
