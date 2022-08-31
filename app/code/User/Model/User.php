<?php

declare(strict_types=1);

class User implements UserInterface
{

    protected array $data =[];

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