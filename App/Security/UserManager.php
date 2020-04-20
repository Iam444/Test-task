<?php
namespace App\Security;

class UserManager
{
    private $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function getUserId(): ? int
    {
        return $_SESSION['id'] ?? null;
    }

    public function getUserRole(): string
    {
        return $_SESSION['role'];
    }

    public function getUser(): array
    {
        return $user = [
            'id' => $this->getUserId(),
            'name' => $_SESSION['name'],
            'role' => $_SESSION['role']
        ];
    }

    public function clearSession(): void
    {
        $this->sessionManager->clearSession();
    }

    public function setAdminSession(): void
    {
        $this->sessionManager->setAdminSession();
    }

    public function checkAdminData(): ? string
    {
        if ($_POST['name'] === ADMIN_NAME && $_POST['pass'] == ADMIN_PASS) {
            return null;
        } else {
            return 'Неверные данные';
        }
    }

    public function checkIfUserIsAdmin(): bool
    {
        if ($this->getUserId() === 1) {
            return true;
        } else {
            return false;
        }
    }
}
