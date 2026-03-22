<?php

namespace Cine\App\Repository;

use Cine\App\Entity\User;
use PDO;

class UserRepository extends Repository
{
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $request = $this->pdo->prepare($sql);
        $request->execute(['email' => $email]);
        $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);

        $user = $request->fetch();

        return $user ?: null;
    }

    public function create(string $email, string $password): void
    {
    $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, 'user')";
    $request = $this->pdo->prepare($sql);
    $request->execute([
        'email'    => $email,
        'password' => $password,
    ]);
    }

    public function findById(int $id): ?User
{
    $sql = "SELECT * FROM users WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['id' => $id]);
    $request->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);
    return $request->fetch() ?: null;
}

public function updateEmail(int $id, string $email): void
{
    $sql = "UPDATE users SET email = :email WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['email' => $email, 'id' => $id]);
}

public function updatePassword(int $id, string $password): void
{
    $sql = "UPDATE users SET password = :password WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['password' => $password, 'id' => $id]);
}

public function delete(int $id): void
{
    $sql = "DELETE FROM users WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['id' => $id]);
}
}