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
        $getRepositoryPost = new PostRepository();
        $post = $getRepositoryPost->getById(intval($id));

        $sxe = new SimpleXMLElement('<?xml version=\'1.0\' standalone=\'yes\'?><post></post>');
        $sxe->addChild('Posttitle', $post->getTitle());
        $sxe->addChild('id', strval($post->getId()));
        $sxe->addChild('body', $post->getBody());
        $sxe->addChild('createdAt', $post->getCreatedAt());
        $user = $sxe->addChild('user');

        $repositoryUser = new UserRepository();
        $userId = $post->getUserId();
        $userInformation = $repositoryUser->getById($userId);

        $user->addChild('username', $userInformation->getName());
        $user->addChild('useremail', $userInformation->getEmail());
        $sxe->saveXML('../app/XML/' . $post->getTitle() . '.xml');

        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename=" ' . $post->getTitle() . '.xml"');
        readfile('../app/XML/' . $post->getTitle() . '.xml');
    }

    public function downloadTemplate(): void
    {
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="../app/XML/template.xml"');
        readfile("../app/XML/template.xml");
    }

    public function validateXML(): void
    {

        $post = new Post();

        $errors = [
            'no_file' => '',
            'file_size' => '',
            'file_type' => '',
            'post_title' => '',
            'post_body' => '',
        ];

        if (empty($_FILES)) {
            $errors['no_file'] = 'No file uploaded';
            $this->view('posts/addxml', $post, $errors);
            return;
        }
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $errors['no_file'] = 'No file uploaded';
                break;
            case UPLOAD_ERR_INI_SIZE:
                $errors['file_size'] = 'File is too large';
                break;
            default:
                $errors['no_file'] = 'An error occoured with the upload';
        }
        if ($_FILES['file']['size'] > 1000000) {
            $errors['file_size'] = 'File is too large';
        }

        if (!empty($errors['no_file']) || !empty($errors['file_size']))
        {
            $this->view('posts/addxml', $post, $errors);
            return;
        }

        $mime_types = ['application/xml', 'text/xml'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (!in_array($mime_type, $mime_types)) {
            $errors['file_type'] = 'File must be an xml file';
            $this->view('posts/addxml', $post, $errors);
            return;
        }

        $pathinfo = pathinfo($_FILES['file']['name']);

        $base = $pathinfo['filename'];

        $base = preg_replace('/^[a-zA-Z0-9-_]/', '_', $base);

        $base = mb_substr($base, 0, 255);

        $date = date('d-m-y h:i:s');

        $this->fileName = $base . $date . '.' . $pathinfo['extension'];

        $this->destination = "/uploads/{$this->fileName}";


        if (move_uploaded_file(
            $_FILES['file']['tmp_name'],
            '/Applications/XAMPP/xamppfiles/htdocs/postme/app/code/Post/Controllers' . $this->destination
        )
        ) {
            $xml = simplexml_load_file(
                '/Applications/XAMPP/xamppfiles/htdocs/postme/app/code/Post/Controllers' . $this->destination
            );



            $post->setUserId($_SESSION['user_id']);

            if (!property_exists('xml', 'Posttitle') && !empty($xml->Posttitle)) {
                $post->setTitle((string)$xml->Posttitle);
            } else {
                $errors['post_title'] = 'No title found in the uploaded file';
            }

            if (!property_exists('xml', 'body') && !empty($xml->body)) {
                $post->setBody((string)$xml->body);
            } else {
                $errors['post_body'] = 'No body found in the uploaded file';
            }
            if (!property_exists('xml', 'id')) {
                $post->setId((int)$xml->id);
            }

            if (!empty($errors['no_file']) || !empty($errors['file_type'])
                || !empty($errors['post_title']) || !empty($errors['post_body'])) {
                $this->view('posts/addxml', $post, $errors);
                return;
            }

            $repositoryPost = new PostRepository();
            try {
                $repositoryPost->save($post);
                redirect('/posts/index/index');
            } catch (Exception $e) {
                $this->errorHandler($e, '/posts/index/index');
            }
        } else {
            var_dump('cannot move to' . $this->destination);
        }
    }

//TODO Accept XML Files
//    1. Make sure files are allowed in the ini ✅
//    2. Add a file upload to the form ✅
//    3. Check for errors in the file ✅
//        a. File size ✅
//        b. no file ✅
//    4. Check mime type just just be XML ✅
//    4.5 Add it to an upload folder? and add datetime to name to make it unique ✅
//    5. Parse XML contained in the file ✅
//    6. Check XML fits the correct format (validation) ✅
//    7. Create query, bind and execute ✅
//    8. Handle basic errors/success ✅
//    9. Refactor the structure of functions
//      a. Create a file handler class the does the download and upload

    public function addxml(): void
    {
        $data = [];

        $this->view('posts/addxml', $data);
    }
}
