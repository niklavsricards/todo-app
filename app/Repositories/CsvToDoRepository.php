<?php

namespace App\Repositories;

use App\Models\Collections\ToDoItemCollection;
use App\Models\ToDoItem;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CsvToDoRepository implements ToDoRepository
{
    private Reader $reader;

    public function __construct()
    {
        $this->reader = Reader::createFromPath('files/todoitems.csv');
        $this->reader->setDelimiter(',');
    }

    public function save(ToDoItem $toDoItem): void
    {
        $writer = Writer::createFromPath('files/todoitems.csv', 'a+');
        $writer->insertOne($toDoItem->toArray());
    }

    public function getAll(): ToDoItemCollection
    {
        $collection = new ToDoItemCollection();

        foreach (iterator_to_array($this->reader->getRecords()) as $record)
        {
            $collection->add(new ToDoItem(
                $record[0],
                $record[1]
            ));
        }
        return $collection;
    }

    public function delete(ToDoItem $toDoItem): void
    {
        $tasks = $this->getAll()->getToDoItems();

        unset($tasks[$toDoItem->getId()]);

        $writer = Writer::createFromPath('files/todoitems.csv', 'w');

        foreach ($tasks as $task)
        {
            $writer->insertOne($task->toArray());
        }
    }

    public function getOne(string $id): ?ToDoItem
    {
        $statement = Statement::create()
            ->where(function ($record) use ($id) {
               return $record[0] === $id;
            })
            ->limit(1);

        $record = $statement
            ->process($this->reader)
            ->fetchOne();

        if (empty($record)) return null;

        return new ToDoItem(
            $record[0],
            $record[1]
        );
    }
}