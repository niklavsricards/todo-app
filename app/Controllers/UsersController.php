<?php

namespace App\Controllers;

use App\Repositories\Users\MySqlUsersRepository;
use App\Repositories\Users\UsersRepository;

class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MySqlUsersRepository();
    }

    public function index(): void
    {
        $users = $this->usersRepository->getAll();

        require_once 'app/Views/users/index.template.php';
    }
}