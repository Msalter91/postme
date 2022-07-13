<?php


declare(strict_types=1);

interface UserRepositoryInterface
{
    public function getById(int $id): User;

    public function save(User $user): ?User;

}

