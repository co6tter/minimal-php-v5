<?php

namespace MyApp;

class Todo
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        Token::create();
    }

    public function processPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Token::validate();
            $action = filter_input(INPUT_GET, 'action');
            switch ($action) {
                case 'add':
                    $this->add();
                    break;
                case 'toggle':
                    $this->toggle();
                    break;
                case 'delete':
                    $this->delete();
                    break;
                case 'purge':
                    $this->purge();
                    break;
                default:
                    exit;
            }

            exit;
        }
    }

    private function add(): void
    {
        $title = trim(filter_input(INPUT_POST, 'title'));
        if ($title === '') {
            return;
        }

        $sql = 'INSERT INTO todos (title) VALUES (:title)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':title', $title, \PDO::PARAM_STR);
        $stmt->execute();
    }

    private function toggle(): void
    {
        $id = filter_input(INPUT_POST, 'id');
        if (empty($id)) {
            return;
        }

        $sql = 'UPDATE todos SET is_done = NOT is_done WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    private function delete(): void
    {
        $id = filter_input(INPUT_POST, 'id');
        if (empty($id)) {
            return;
        }

        $sql = 'DELETE FROM todos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    private function purge(): void
    {
        $sql = 'DELETE FROM todos WHERE is_done = 1';
        $this->pdo->query($sql);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM todos ORDER BY id DESC');
        $todos = $stmt->fetchAll();
        return $todos;
    }
}
