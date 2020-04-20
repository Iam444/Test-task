<?php
namespace App\Security;

class SecurityManager
{
    private $userManager;
    private $accessAllowed = null;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function canUserAccessPage(): bool
    {
        return $this->accessAllowed ?? false;
    }

    public function allowAccessToAdmin(): void
    {
        $roleName = ADMIN_NAME;
        $role = $this->userManager->getUserRole();
        if ($role === $roleName) {
            $this->allowAccess();
        }
    }

    private function allowAccess(): void
    {
        $this->accessAllowed = true;
    }

    public function denyAccess(): void
    {
        $this->accessAllowed = false;
    }
}
