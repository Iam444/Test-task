<?php
namespace App\Core;

use PDO;

class Database
{
    private $pdo;

    public function __construct()
    {
        $config = $this->getPDOSettings();
        $this->pdo = new PDO($config['dsn'], $config['user'], $config['pass'], $config['opt']);
    }

    protected function getPDOSettings(): array
    {
        $config['dsn'] = DATABASE_TYPE . ":host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME . ";charset=" . DATABASE_CHARSET;
        $config['user'] = DATABASE_USER;
        $config['pass'] = DATABASE_PASSWORD;
        $config['opt'] = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return $config;
    }

    public function execute($query, array $params = null): array
    {
        if (is_null($params)) {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll();
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
