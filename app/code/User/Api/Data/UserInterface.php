<?php

declare(strict_types=1);

interface UserInterface {

    public const ID = 'id';
    public const NAME = 'name';
    public const EMAIL = 'body';
    public const PASSWORD = 'password';
    public const CREATEDAT = 'created_at';

    public function getId() :int;
    public function setId(int $id);

    public function getName() :string;
    public function setUserId(string $name);

    public function getEmail() :string;
    public function setEmail(string $email);

    public function getPassword() :string;
    public function setPassword(string $password);

    public function getCreatedAt() :string;
    public function setCreatedAt(string $datetime);


}
