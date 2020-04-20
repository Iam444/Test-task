<?php
namespace App\Models;

use App\Core\Database;

class TasksModel
{
    private $database;
    private $messageMng = null;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getMessage(): ? string
    {
        return $this->messageMng;
    }

    public function setMessage($message)
    {
        return $this->messageMng = $message;
    }

    public function getTasks(): ? array
    {
        $param = $this->getSortParameters();
        $query = 'SELECT * FROM tasks ORDER BY ' . $param['order'] . ' ' . $param['direct'];
        $tasks = $this->database->execute($query);

        if (!empty($tasks)) {
            return $this->splitOnPages($tasks);
        } else {
            return null;
        }
    }

    public function getSortParameters(): array
    {
        $param['order'] = $this->getSortBy();
        $param['direct'] = $this->getSortDirection();

        return $param;
    }

    public function getSortDirection(): string
    {
        return $_GET['direct'] ?? '';
    }

    public function getSortBy(): string
    {
        if (isset($_GET['order'])) {
            return ($_GET['order'] == 'status') ? 'is_done' : $_GET['order'];
        } else {
            return 'id';
        }
    }

    public function splitOnPages($tasks): ? array
    {
        $i = 0;

        while (!empty($tasks[$i])) {
            $j = 1;
            $page = array($j => $tasks[$i]);

            while ($j <= 3 && !empty($tasks[$i])) {
                if ($j != 1) {
                    array_push($page, $tasks[$i]);
                }
                $i++;
                $j++;
            }

            if (empty($pages)) {
                $pages = array('page_1' => $page);
            } else {
                $pages[] = $page;
            }
        }

        return $pages ?? null;
    }

    public function createTask()
    {
        $date = new \DateTime('now');
        $params = [
            'author' => htmlspecialchars($_POST['author']),
            'email' => htmlspecialchars($_POST['email']),
            'content' => htmlspecialchars($_POST['content']),
            'created_at' => $date->format('Y-m-d H:i:s')
        ];
        $query = 'INSERT INTO tasks (author, email, content, created_at) VALUES (:author, :email, :content, :created_at)';
        $this->database->execute($query, $params);
    }

    public function editTask()
    {
        $params = [
            'author' => htmlspecialchars($_POST['author']),
            'email' => htmlspecialchars($_POST['email']),
            'content' => htmlspecialchars($_POST['content']),
            'id' => $_POST['id']
        ];

        if ($this->ifContentUpdated($params)) {
            $date = new \DateTime('now');
            $params['updated_at'] = $date->format('Y-m-d H:i:s');
            $query = 'UPDATE tasks SET author = :author, email = :email, content = :content, updated_at = :updated_at WHERE id = :id';
        } else {
            $query = 'UPDATE tasks SET author = :author, email = :email, content = :content WHERE id = :id';
        }

        $this->database->execute($query, $params);
    }

    public function ifContentUpdated($params): bool
    {
        $query = 'SELECT content FROM tasks WHERE id = :id';
        $idParam[] = $params['id'];
        $result = $this->database->execute($query, $idParam);
        $row = $result[0];

        if ($params['content'] !== $row['content']) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatus()
    {
        $params = [
            'id' => $_POST['id'],
            'is_done' => $_POST['status'] ? 0 : 1
        ];
        $query = 'UPDATE tasks SET is_done = :is_done WHERE id = :id';
        $this->database->execute($query, $params);
    }
}
