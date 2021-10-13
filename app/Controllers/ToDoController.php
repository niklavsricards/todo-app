<?php

namespace App\Controllers;

use App\Models\ToDoItem;
use App\Repositories\CsvToDoRepository;
use App\Repositories\MySqlToDoRepository;
use App\Repositories\ToDoRepository;
use Ramsey\Uuid\Uuid;

class ToDoController
{
    private ToDoRepository $toDoRepository;

    public function __construct()
    {
        //$this->toDoRepository = new CsvToDoRepository();
        $this->toDoRepository = new MySqlToDoRepository();
    }

    public function index(): void
    {
        if (isset($_SESSION['loggedIn'])) {
            $toDoItems = $this->toDoRepository->getAll($_SESSION['user_id']);
            require_once 'app/Views/index.template.php';
        } else {
            header('Location: /login');
        }
    }

    public function create(): void
    {
        $item = new ToDoItem(
            Uuid::uuid4(),
            $_POST['title'],
            $_SESSION['user_id']
        );

        $this->toDoRepository->save($item);

        header('Location: /todos');
    }

    public function delete(array $vars): void
    {
        $id = $vars['id'] ?? null;

        if ($id == null) header('Location: /');

        $task = $this->toDoRepository->getOne($id);

        if ($task !== null)
        {
            $this->toDoRepository->delete($task);
        }

        header('Location: /');
    }
}