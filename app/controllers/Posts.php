<?php

class Posts extends Controller
{

    protected ?object $postModel = null;

    public function __construct()
    {
        if(!isLoggedIn()){
            redirect('users/login');
        }
        //TODO Wouldn't we want a flash message here? Otherwise it seems like a random redirect

        $this->postModel = $this->model('Post');
    }

    public function index() {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

}