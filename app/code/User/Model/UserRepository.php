<?php

declare(strict_types=1);

use library\Database as Database;

class UserRepository implements UserRepositoryInterface
{

    protected ?Database $db = null;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getById(int $id): User
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');

        $this->db->bind(':id', $id);

        $result = $this->db->singleResult();

        $user = new User();

        if (!$result) {
            $user->setEmail('');
            return $user;
        }

        $user->setId($result->id);
        $user->setEmail($result->email);
        $user->setName($result->name);
        $user->setPassword($result->password);

        return $user;
    }

    public function getByEmail(string $email): User
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');

        $this->db->bind(':email', $email);

        $result = $this->db->singleResult();

        $user = new User();

        if (!$result) {
            $user->setEmail('');
            return $user;
        }



        $user->setId($result->id);
        $user->setEmail($result->email);
        $user->setName($result->name);
        $user->setPassword($result->password);

        return $user;
    }

    public function save(User $user): ?User
    {
        $this->db->query(
            'INSERT INTO users (name, email, password) 
        VALUES (:name, :email, :password)'
        );

        $this->db->bind(':name', $user->getName());
        $this->db->bind(':email', $user->getEmail());
        $this->db->bind(':password', $user->getPassword());

        try {
            $this->db->execute();
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
