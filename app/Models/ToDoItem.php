<?php

namespace App\Models;

class ToDoItem
{
    private string $id;
    private string $title;
    private string $userId;

    public function __construct(string $id, string $title, ?string $userId = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'user_id' => $this->getUserId()
        ];
    }

}