<?php

namespace App\Models;

class ToDoItem
{
    private string $todo;

    public function __construct(string $todo)
    {
        $this->todo = $todo;
    }

    public function getTodo(): string
    {
        return $this->todo;
    }
}