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

    public function getById(int $id): Post
    {
        $this->db->query('SELECT * FROM posts WHERE id = :id');


        $this->db->bind(':id', $id);

            $result = $this->db->singleResult();

            if(!$result){
                throw new Exception("Post not found");
            }

            $post = new Post();

            $post->setId($result->id);
            $post->setBody($result->body);
            $post->setTitle($result->title);
            $post->setUserId($result->user_id);
            $post->setCreatedAt($result->created_at);

            return $post;
    }

    public function deleteById(int $id): bool
    {
        $this->db->query('DELETE FROM posts where id = :id');

        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        }
        else {
            return false;
        }
    }

    public function save(Post $post): ?Post
    {
        if(!$post->getCreatedAt()){
            $this->db->query('INSERT INTO post (title, body, user_id) 
            VALUES (:title, :body, :user_id)');
            $this->db->bind(':user_id', $post->getUserId());
        } else {
            $this->db->query('UPDATE post SET title = :title, body = :body WHERE id = :id');
            $this->db->bind(':id', $post->getId());
        }

        $this->db->bind(':title', $post->getTitle());
        $this->db->bind(':body', $post->getBody());

        try {
            $this->db->execute();
            return $post;
        } catch(Exception $e) {
            throw new Exception("Unable to upload post due to database problem");
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

        try {
            return $this->db->resultSet();
        } catch(Exception $e) {
            throw new Exception("There has been a problem connecting to the Database.");
        }


    }
}