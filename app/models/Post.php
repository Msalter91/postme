<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();

    }
    // Add function to get single post and pass data

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

    // Add function to edit post

    // Add function to delete post
}