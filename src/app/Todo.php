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
                    $id = $this->add();
                    header('Content-Type: application/json');
                    echo json_encode(['id' => $id]);
                    break;
                case 'toggle':
                    $isDone = $this->toggle();
                    header('Content-Type: application/json');
                    echo json_encode(['is_done' => $isDone]);
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

    private function add(): int
    {
        $title = trim(filter_input(INPUT_POST, 'title'));
        if ($title === '') {
            return -1;
        }

        $sql = 'INSERT INTO todos (title) VALUES (:title)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':title', $title, \PDO::PARAM_STR);
        $stmt->execute();
        return (int) $this->pdo->lastInsertId();
    }

    private function toggle(): bool
    {
        $id = filter_input(INPUT_POST, 'id');
        if (empty($id)) {
            return false;
        }

        $sql = 'SELECT * FROM todos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $todo = $stmt->fetch();
        if (empty($todo)) {
            header('HTTP', true, 404);
            exit;
        }

        $sql = 'UPDATE todos SET is_done = NOT is_done WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return (bool) !$todo->is_done;
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
