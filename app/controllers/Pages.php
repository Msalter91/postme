<?php

class Pages extends Controller
{
    public function __construct() {

        $this->postModel = $this->model('Post');

    }

    public function index() {
        $posts = $this->postModel->getPosts();
        $data =  ['title'=> 'Stranger',
        'posts' => $posts];
        $this->view('pages/index', $data);


    }

    public function about() {
        // Added default argument here to prevent error from an incorrect url
        $data =  ['title'=> 'about'];
        $this->view('pages/about', $data);
    }
}