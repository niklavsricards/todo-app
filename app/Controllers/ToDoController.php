<?php

namespace App\Controllers;

use App\Models\Collections\ToDoItemCollection;
use App\Models\ToDoItem;
use League\Csv\Reader;
use League\Csv\Writer;

class ToDoController
{
    public function index(): void
    {
        $itemsFromFile = iterator_to_array(Reader::createFromPath('files/todoitems.csv', 'r')
        ->getRecords());

        $items = [];

        foreach ($itemsFromFile as $item)
        {
            $items[] = new ToDoItem($item[0]);
        }

        $toDoItems = new ToDoItemCollection($items);

        require_once 'app/Views/index.template.php';
    }

    public function create(): void
    {
        $writer = Writer::createFromPath('files/todoitems.csv', 'a+');

        $writer->insertOne([
            $_POST['toDoText']
        ]);

        header('Location: /todos');
    }
}