<?php

declare(strict_types=1);

class User implements UserInterface
{
    private ?Database $db = null;
    private array $data = [];

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($data): bool
    {
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password): bool | object
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind('email', $email);

        $row = $this->db->singleResult();
        $hashed_password = $row->password;

        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }


    public function findUserByEmail($email): bool
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->singleResult();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id): bool | object
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->singleResult();
    }

    public function getId(): int
    {
        return (int)$this->__get(self::ID);
    }

    public function setId(int $id)
    {
        $this->__set(self::ID, $id);
    }

    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    public function setUserId(string $name)
    {
        // TODO: Implement setUserId() method.
    }

    public function getEmail(): string
    {
        // TODO: Implement getEmail() method.
    }

    public function setEmail(string $email)
    {
        // TODO: Implement setEmail() method.
    }

    public function getPassword(): string
    {
        // TODO: Implement getPassword() method.
    }

    public function setPassword(string $password)
    {
        // TODO: Implement setPassword() method.
    }

    public function getCreatedAt(): string
    {
        // TODO: Implement getCreatedAt() method.
    }

    public function setCreatedAt(string $datetime)
    {
        // TODO: Implement setCreatedAt() method.
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->data)) {
            return null;
        }

        return $this->data[$name];
    }
}