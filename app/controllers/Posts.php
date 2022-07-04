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
        $this->userModel = $this->model('User');
    }

    public function index() {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    public function add() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //sanitize

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_error' => '',
                'body_error' => ''
            ];

            //validate the title

            if(empty($data['title'])){
                $data['title_error'] = 'Please enter a title';
            }

            if(empty($data['body'])){
                $data['body_error'] = 'Please enter some text';
            }

            if(empty($data['title_error'])  && empty($data['body_error'])){
                if($this->postModel->addPost($data)){
                    flash('post_message', 'Post added');
                    redirect('/posts');
                } else {
                    die('There has been an error');
                }
            } else {
                $this->view('posts/add', $data);
            }

        } else {
            $data = ["title" => '',
                "body" => ''
            ];

            $this->view('posts/add', $data);
        }
    }

    public function show($id) {

        $post = $this->postModel->getPostbyId($id);

        //TODO This seems silly, we wouldn't we just do a join?
        $user = $this->userModel->getUserById($post->user_id);

        $data = ['post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }
}