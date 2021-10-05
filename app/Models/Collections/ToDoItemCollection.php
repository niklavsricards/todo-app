<?php

namespace App\Models\Collections;

use App\Models\ToDoItem;

class ToDoItemCollection
{
    private array $toDoItems = [];

    public function __construct(array $toDoItems)
    {
        foreach ($toDoItems as $item)
        {
            $this->add($item);
        }
    }

    public function add(ToDoItem $item): void
    {
        $this->toDoItems[] = $item;
    }

    public function getToDoItems(): array
    {
        return $this->toDoItems;
    }
}