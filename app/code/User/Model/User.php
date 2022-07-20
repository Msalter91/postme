<?php

declare(strict_types=1);

class User implements UserInterface
{

    protected array $data =[];
//    private ?Database $db = null;
//    private array $data = [];
//
//    public function __construct()
//    {
//        $this->db = new Database();
//    }
//
//    public function register(array $data): bool
//    {
//        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
//
//        $this->db->bind(':name', $data['name']);
//        $this->db->bind(':email', $data['email']);
//        $this->db->bind(':password', $data['password']);
//
//        if ($this->db->execute()) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    public function login(string $email, string $password): bool | object
//    {
//        $this->db->query('SELECT * FROM users WHERE email = :email');
//        $this->db->bind('email', $email);
//
//        $row = $this->db->singleResult();
//        $hashed_password = $row->password;
//
//        if (password_verify($password, $hashed_password)) {
//            return $row;
//        } else {
//            return false;
//        }
//    }
//
//
//    public function findUserByEmail(string $email): bool
//    {
//        $this->db->query('SELECT * FROM users WHERE email = :email');
//        $this->db->bind(':email', $email);
//
//        $row = $this->db->singleResult();
//
//        if ($this->db->rowCount() > 0) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    public function getUserById(int $id): bool | object
//    {
//        $this->db->query('SELECT * FROM users WHERE id = :id');
//        $this->db->bind(':id', $id);
//
//        return $this->db->singleResult();
//    }

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
        return (string)$this->__get(self::NAME);
    }

    public function setName(string $name)
    {
        $this->__set(self::NAME, $name);
    }

    public function getEmail(): string
    {
        return (string)$this->__get(self::EMAIL);
    }

    public function setEmail(string $email)
    {
        $this->__set(self::EMAIL, $email);
    }

    public function getPassword(): string
    {
        return (string)$this->__get(self::PASSWORD);
    }

    public function setPassword(string $password)
    {
        $this->__set(self::PASSWORD, $password);
    }

    public function getCreatedAt(): string
    {
        return (string)$this->__get(self::CREATEDAT);
    }

    public function setCreatedAt(string $datetime)
    {
        $this->__set(self::CREATEDAT, $datetime);
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