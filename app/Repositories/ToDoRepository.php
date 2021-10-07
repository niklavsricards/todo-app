<?php

namespace App\Repositories;

use App\Models\Collections\ToDoItemCollection;
use App\Models\ToDoItem;

interface ToDoRepository
{
    public function save(ToDoItem $toDoItem): void;
    public function getAll(): ToDoItemCollection;
    public function delete(ToDoItem $toDoItem): void;
    public function getOne(string $id): ?ToDoItem;
}