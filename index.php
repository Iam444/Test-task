<?php

use App\Core\Engine;

require_once './App/config.php';

$action = $_GET['action'] ?? NULL;

switch ($action) {
    case 'edit':
        echo Engine::getMainController()->getTasksController()->editTask();
        break;
    case 'create':
        echo Engine::getMainController()->getTasksController()->createTask();
        break;
    case 'changeStatus':
        echo Engine::getMainController()->getTasksController()->changeStatus();
        break;
    case 'login':
        echo Engine::getMainController()->getUsersController()->index();
        break;
    case 'logout':
        echo Engine::getMainController()->getUsersController()->logout();
        break;
    case 'validate':
        echo Engine::getMainController()->getUsersController()->validate();
        break;
    default:
        echo Engine::getMainController()->getTasksController()->index();
        break;
}

