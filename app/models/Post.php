<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();

    }
    // Add function to get single post and pass data

    public function getPostById($id){
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->singleResult();

        return $row;
    }

    public function getPosts(){
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

    // Add function to get all the posts and pass data

    // Add function to add post

    public function addPost($data) {
        $this->db->query('INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)');

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Add function to edit post

    public function updatePost($data) {
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');

        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':id', $data['id']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Add function to delete post

    public function deletePost($id){
        $this->db->query('DELETE FROM posts WHERE id = :id');

        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}