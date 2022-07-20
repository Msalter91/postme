<?php

declare(strict_types=1);

use library\Controller as Controller;

class Index extends Controller
{
    protected ?object $postModel = null;

    public function index(): void
    {
        $repositoryPost = new PostRepository();
        try {
            $results = $repositoryPost->getList();
        } catch (Exception $e) {
            $this->errorHandler($e, 'pages/index/error');
        }

        $data = [
            'posts' => $results
        ];

        $this->view('posts/index', $data);
    }

    /**
     * @return void
     */
    public function add(): void
    {
        $post = new Post();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post->setTitle(trim($_POST['title']));
            $post->setBody(trim($_POST['body']));
            $post->setUserId($_SESSION['user_id']);
            $errors = [
                'title_error' => '',
                'body_error' => ''
            ];

            if (empty($_POST['title'])) {
                $errors['title_error'] = 'Please enter a title';
            }

            if (empty($_POST['body'])) {
                $errors['body_error'] = 'Please enter some text';
            }

            $repositoryPost = new PostRepository();

            if (empty($errors['title_error']) && empty($errors['body_error'])) {
                try {
                    $repositoryPost->save($post);
                    redirect('/posts/index/index');
                } catch (Exception $e) {
                    $this->errorHandler($e, '/posts/index/index');
                }
            } else {
                $this->view('posts/add', $post, $errors);
            }
        } else {
            $this->view('posts/add', $post);
        }
    }

    /**
     * @throws Exception
     * @returns null
     */
    public function edit($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $respositoryPost = new PostRepository();
            $post = $respositoryPost->getById(intval($id));

            if ($post->getUserId() != $_SESSION['user_id']) {
                redirect('posts/index/index');
                return;
            }

            $this->view('posts/edit', $post);
            return;
        }
        $editedPost = new Post();

        $editedPost->setTitle(trim($_POST['title']));
        $editedPost->setBody(trim($_POST['body']));
        $editedPost->setId(intval($id));
        $editedPost->setUserId($_SESSION['user_id']);

        $errors = [
            'title_error' => '',
            'body_error' => ''
        ];

        if (empty($editedPost->getTitle())) {
            $errors['title_error'] = 'Please enter a title';
        }

        if (empty($editedPost->getBody())) {
            $errors['body_error'] = 'Please enter some text';
        }

        if (empty($errors['title_error']) && empty($errors['body_error'])) {
            $submissionRepositoryPost = new PostRepository();

            try {
                $submissionRepositoryPost->save($editedPost);
                redirect('/posts/index/index');
            } catch (Exception $e) {
                $this->errorHandler($e, '/posts/index/index');
            }
        } else {
            $this->view('posts/edit', $editedPost, $errors);
        }
    }

    public function show($id): void
    {
        $RepositoryPost = new PostRepository();
        try {
            $result = $RepositoryPost->getById(intval($id));
            $this->view('posts/show', $result);
        } catch (Exception $e) {
            $this->errorHandler($e, 'pages/index/index');
        }
    }

    /**
     * @throws Exception
     * @returns null
     */
    public function delete($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('post/index/show/' . $id);
            return;
        }

        $getRepositoryPost = new PostRepository();
        $post = $getRepositoryPost->getById(intval($id));
        $postid = $post->getUserId();

        if ($postid != $_SESSION['user_id']) {
            redirect('post/index/show/' . $id);
        }
        try {
            $getRepositoryPost->deleteById(intval($id));
            flash('post_message', 'Post removed successfully');
            redirect('posts');
        } catch (Exception $e) {
            $this->errorHandler($e, 'pages/index/index');
        }
    }
}
