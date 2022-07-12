<?php

declare(strict_types=1);

class Post implements PostInterface
{

    private array $data = [];

    public function getId(): int
    {
        return (int)$this->__get(self::ID);
    }

    public function setId(int $id)
    {
        $this->__set(self::ID, $id);
    }

    public function getUserId(): int
    {
        return (int)$this->__get(self::USERID);
    }

    public function setUserId(int $userId)
    {
        $this->__set(self::USERID, $userId);
    }

    public function getTitle(): string
    {
        return (string)$this->__get(self::TITLE);
    }

    public function setTitle(string $title)
    {
        $this->__set(self::TITLE, $title);
    }

    public function getBody(): string
    {
        return (string)$this->__get(self::BODY);
    }

    public function setBody(string $body)
    {
        $this->__set(self::BODY, $body);
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
