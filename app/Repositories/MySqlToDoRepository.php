<?php

namespace App\Repositories;

use App\Models\Collections\ToDoItemCollection;
use App\Models\ToDoItem;
use PDO;

class MySqlToDoRepository implements ToDoRepository
{
    public \PDO $pdo;
    public static MySqlToDoRepository $db;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=todolist', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function save(ToDoItem $toDoItem): void
    {
        $statement = $this->pdo->prepare('INSERT INTO to_do_items (id, todo, user_id)
        VALUE (:id, :todo, :user_id)');

        $statement->bindValue(':id', $toDoItem->getId());
        $statement->bindValue(':todo', $toDoItem->getTitle());
        $statement->bindValue(':user_id', $toDoItem->getUserId());

        $statement->execute();
    }

    public function getAll($user_id): ToDoItemCollection
    {
        $collection = new ToDoItemCollection();

        $statement = $this->pdo->prepare('SELECT * FROM to_do_items WHERE user_id = :user_id');
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $item)
        {
            $collection->add(new ToDoItem(
                $item['id'],
                $item['todo'],
                $item['user_id']
            ));
        }

        return $collection;
    }

    public function delete(ToDoItem $toDoItem): void
    {
        $statement = $this->pdo->prepare('DELETE FROM to_do_items WHERE id = :id');
        $statement->bindValue(':id', $toDoItem->getId());
        $statement->execute();
    }

    public function getOne(string $id): ?ToDoItem
    {
        $statement = $this->pdo->prepare('SELECT * FROM to_do_items WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $item = $statement->fetch(PDO::FETCH_ASSOC);

        if (empty($item)) return null;

        return new ToDoItem(
            $item['id'],
            $item['todo'],
            $item['user_id']
        );
    }
}