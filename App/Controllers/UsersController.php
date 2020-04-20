<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Render;
use App\Security\UserManager;

class UsersController extends BaseController
{
    public function __construct(Render $render, UserManager $userManager)
    {
        parent::__construct($render, null, null, $userManager);
    }

    public function index($errorMsg = null)
    {
        return $this->render->render('common/authorization.html', [
            'errorMsg' => $errorMsg
        ]);
    }

    public function validate()
    {
        $errorMsg = $this->userManager->checkAdminData();

        if (!$errorMsg) {
            $this->userManager->setAdminSession();
            $this->redirectToIndex();
        } else {
            return $this->index($errorMsg);
        }
    }

    public function logout()
    {
        $this->userManager->clearSession();
        $this->redirectToIndex();
    }
}
