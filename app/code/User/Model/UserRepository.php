<?php

declare(strict_types=1);

class UserRepository implements UserRepositoryInterface
{

    protected ?Database $db = null;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getById(int $id): User
    {
        // TODO: Implement getById() method.
    }

    public function save(User $user): ?User
    {
        // TODO: Implement save() method.
    }
}