<?php

declare(strict_types=1);

interface PostInterface
{
    public const ID = 'id';
    public const USERID = 'user_id';
    public const TITLE = 'title';
    public const BODY = 'body';
    public const CREATEDAT = 'created_at';

    public function getId(): int;

    public function setId(int $id);

    public function getUserId(): int;

    public function setUserId(int $userId);

    public function getTitle(): string;

    public function setTitle(string $title);

    public function getBody(): string;

    public function setBody(string $body);

    public function getCreatedAt(): string;
}
