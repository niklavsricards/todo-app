<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\Users\MySqlUsersRepository;
use App\Repositories\Users\UsersRepository;
use Ramsey\Uuid\Uuid;

class AuthController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MySqlUsersRepository();
    }

    public function login(): void
    {
        $errors = [];

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email)) {
            array_push($errors, "E-mail address was not provided");
        }
        if (empty($password)) {
            array_push($errors, "Password was not provided");
        }

        if (count($errors) == 0) {
            $check = $this->usersRepository->loginAttempt($email);
        }

        if ($check && password_verify($password, $check->getPasswordHash())) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_id'] = $check->getId();
            $_SESSION['name'] = $check->getName();
            header('Location: /todos');
        } else {
            array_push($errors, "E-mail and/or password is not correct");

            require_once 'app/Views/auth/login.template.php';
        }

    }

    public function register(): void
    {
        $errors = [];

        $id = Uuid::uuid4();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password1 = $_POST['password'];
        $password2 = $_POST['passwordConfirm'];

        if ($password1 != $password2) {
            array_push($errors, "Passwords don't match");
        }

        $user = new User($id, $name, $email);

        $check = $this->usersRepository->checkEmail($user);

        if ($check) {
            if ($check->getEmail() === $user->getEmail()) {
                array_push($errors, "A user with an e-mail address {$email} already exists");
            }
        }

        if (count($errors) == 0) {
            $password = password_hash($password1, PASSWORD_BCRYPT);
            $this->usersRepository->register($user, $password);

            $_SESSION['loggedIn'] = true;
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['name'] = $user->getName();

            header('Location: /todos');
        } else {
            require_once 'app/Views/auth/register.template.php';
        }
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
    }

    public function loginView(): void
    {
        $errors = [];
        require_once 'app/Views/auth/login.template.php';
    }

    public function registerView(): void
    {
        $errors = [];
        require_once 'app/Views/auth/register.template.php';
    }
}