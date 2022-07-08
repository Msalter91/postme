<?php

declare(strict_types=1);

require_once 'Post.php';


class PostRepository implements PostRepositoryInterface
{
    protected ?Database $db = null;
    public function __construct()
    {
        $this->db = new Database();
    }

    // This is where all of the SQL and database stuff will happen
    public function getById(int $id): Post
    {
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);

        $result = $this->db->singleResult();

        $post = new Post();

        $post->setId($result->id);
        $post->setBody($result->body);
        $post->setTitle($result->title);
        $post->setUserId($result->user_id);
        $post->setCreatedAt($result->created_at);

        return $post;

    }

    public function deleteById(int $id): void
    {
        // TODO: Implement deleteById() method.
    }

    public function save(Post $post): ?Post
    {
        if(!$post->getCreatedAt()){
            $this->db->query('INSERT INTO posts (title, body, user_id) 
            VALUES (:title, :body, :user_id)');
        }

        $this->db->bind(':title', $post->getTitle());
        $this->db->bind(':body', $post->getBody());
        $this->db->bind(':user_id', $post->getUserId());

        if($this->db->execute()){
            return $post;
        } else {
            return null;
        }

    }

    public function getList()
    {
        $this->db->query('SELECT *,
                               posts.id as postId,
                               users.id as userId,
                               posts.created_at as postsCreated,
                               users.created_at as usersCreated
                               FROM Posts
                               INNER JOIN users
                               ON posts.user_id = users.id
                               ORDER BY posts.created_at DESC');

        return $this->db->resultSet();
    }
}