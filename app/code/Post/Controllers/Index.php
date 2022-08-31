<?php

declare(strict_types=1);

use library\Controller as Controller;

class Index extends Controller
{
    protected ?object $postModel = null;

    private string $fileName;
    private string $destination;

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

    public function createXML($id)
    {
        $xml = new Xml();
        $xml->createXmlFromPost($id);
    }

    public function downloadTemplate(): void
    {
        $xml = new Xml();
        $xml->downloadTemplate();
    }

    public function validateXML(): void
    {
        $xmlUpload = new Xml();
        $post = new Post();

        $errors = $xmlUpload->checkValidFile();

        if (!empty($errors)) {
            $this->view('posts/addxml', $post, $errors);
            return;
        }

        try {
            $xmlFile = $xmlUpload->moveFile();
        } catch (Exception $e) {
            $this->errorHandler($e, '/posts/index/index');
        }

        $post->setUserId($_SESSION['user_id']);

        $repositoryPost = new PostRepository();

        if (!property_exists('xmlFile', 'Posttitle') && !empty($xmlFile->Posttitle)) {
            $post->setTitle((string)$xmlFile->Posttitle);
        } else {
            $errors['post_title'] = 'No title found in the uploaded file';
        }

        if (!property_exists('xmlFile', 'body') && !empty($xmlFile->body)) {
            $post->setBody((string)$xmlFile->body);
        } else {
            $errors['post_body'] = 'No body found in the uploaded file';
        }

        if (!property_exists('xmlFile', 'id')) {
            $post->setId((int)$xmlFile->id);
            try {
                $repositoryPost->checkOwner($post->getId());
            } catch (Exception $e) {
                $this->errorHandler($e, '/posts/index/index');
            }
        }

        if (!empty($errors['post_title']) || !empty($errors['post_body'])) {
            $this->view('posts/addxml', $post, $errors);
            return;
        }

        try {
            $repositoryPost->save($post);
            redirect('/posts/index/index');
        } catch (Exception $e) {
            $this->errorHandler($e, '/posts/index/index');
        }
    }

    public function addxml(): void
    {
        $data = [];

        $this->view('posts/addxml', $data);
    }
}
