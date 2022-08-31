<?php

declare(strict_types=1);

class Post implements PostInterface
{
    private array $data = [];

    public function getId(): int
    {
        return (int)$this->__get(self::ID);
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->__set(self::ID, $id);
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return (int)$this->__get(self::USERID);
    }

    /**
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->__set(self::USERID, $userId);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->__get(self::TITLE);
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->__set(self::TITLE, $title);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return (string)$this->__get(self::BODY);
    }

    /**
     * @param string $body
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->__set(self::BODY, $body);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return (string)$this->__get(self::CREATEDAT);
    }

    /**
     * @param string $datetime
     * @return void
     */
    public function setCreatedAt(string $datetime): void
    {
        $this->__set(self::CREATEDAT, $datetime);
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name): mixed
    {
        if (!array_key_exists($name, $this->data)) {
            return null;
        }

        return $this->data[$name];
    }
}
