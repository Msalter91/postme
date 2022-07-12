<?php


class Index extends Controller
{

    protected ?object $postModel = null;

    public function index()
    {
        $repositoryPost = new PostRepository();
        try {
            $results = $repositoryPost->getList();
        } catch (Exception $e) {
            flash('post_message', $e->getMessage(), 'alert alert-danger');
            redirect('pages/index/error');
        }

        $data = [
            'posts' => $results
        ];

        $this->view('posts/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize
            $post = new Post;

            $post->setTitle(trim($_POST['title']));
            $post->setBody(trim($_POST['body']));
            $post->setUserId($_SESSION['user_id']);
            $errors = [
                'title_error' => '',
                'body_error' => ''
            ];

            //validate the title

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
                    flash('post_message', $e->getMessage(), 'alert alert-danger');
                    redirect('/posts/index/index');
                }
            } else {
                $this->view('posts/add', $post, $errors);
            }
        } else {
            $post = new Post();

            $this->view('posts/add', $post);
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $editedPost = new Post();

            $editedPost->setTitle(trim($_POST['title']));
            $editedPost->setBody(trim($_POST['body']));
            $editedPost->setId($id);
            $editedPost->setUserId($_SESSION['user_id']);

            $errors = [
                'title_error' => '',
                'body_error' => ''
            ];

            //validate the title

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
                    flash('post_message', $e->getMessage(), 'alert alert-danger');
                    redirect('/posts/index/index');
                }
            } else {
                $this->view('posts/edit', $editedPost, $errors);
            }
        } else {
            //Get existing post form model
            $respositoryPost = new PostRepository();
            $post = $respositoryPost->getById($id);

            //Check ownership
            if ($post->getUserId() != $_SESSION['user_id']) {
                redirect('posts/index/index');
            }

            $this->view('posts/edit', $post);
        }
    }

    public function show($id)
    {
        $RepositoryPost = new PostRepository();
        try {
            $result = $RepositoryPost->getById($id);
            $this->view('posts/show', $result);
        } catch (Exception $e) {
            flash('post_message', $e->getMessage(), 'alert alert-danger');
            redirect('pages/index/index');
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $getRepositoryPost = new PostRepository();
            $post = $getRepositoryPost->getById($id);

            $postid = $post->getUserId();
            var_dump($_SESSION['user_id']);

            if ($postid != $_SESSION['user_id']) {
                redirect('post/index/show/' . $id);
            }

            if ($getRepositoryPost->deleteById($id)) {
                flash('post_message', 'Post removed successfully');
                redirect('posts');
            } else {
                die('Something has gone wrong');
            }
        } else {
            redirect('post/index/show/' . $id);
        }
    }
}