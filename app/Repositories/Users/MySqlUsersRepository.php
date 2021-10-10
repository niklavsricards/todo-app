<?php

namespace App\Repositories\Users;

use App\Models\Collections\UsersCollection;
use App\Models\User;
use PDO;

class MySqlUsersRepository implements UsersRepository
{
    public \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=localhost;port=3306;dbname=todolist', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function getAll(): UsersCollection
    {
        $collection = new UsersCollection();

        $statement = $this->pdo->prepare('SELECT * FROM users');
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $user)
        {
            $collection->add(new User(
                $user['id'],
                $user['name'],
                $user['email']
            ));
        }

        return $collection;
    }

    public function checkEmail(User $user): ?User
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->bindValue(':email', $user->getEmail());
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            return new User(
                $result['id'],
                $result['name'],
                $result['email']
            );
        } else {
            return null;
        }
    }

    public function register(User $user, string $password): void
    {
        $statement = $this->pdo->prepare('INSERT INTO users (id, name, email, password)
        VALUE (:id, :name, :email, :password)');

        $statement->bindValue(':id', $user->getId());
        $statement->bindValue(':name', $user->getName());
        $statement->bindValue(':email', $user->getEmail());
        $statement->bindValue(':password', $password);

        $statement->execute();
    }

    public function loginAttempt(string $email, string $password): ?User
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = :email 
                      AND password = :password LIMIT 1');
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            return new User(
                $result['id'],
                $result['name'],
                $result['email']
            );
        } else {
            return null;
        }
    }
}