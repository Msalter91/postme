<?php

declare(strict_types=1);

interface PostRepositoryInterface
{
    public function getById(int $id): Post;

    public function deleteById(int $id): bool;

    public function save(Post $post): ?Post;

    public function getList();
}
