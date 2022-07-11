<?php



class Index extends Controller
{

    protected ?object $postModel = null;

    public function index(){
        $repositoryPost = new PostRepository();
        $results = $repositoryPost->getList();

        $data = [
            'posts' => $results
        ];

        $this->view('posts/index', $data);

    }

    public function add() {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //sanitize
            $post = new Post;

            $post->setTitle(trim($_POST['title']));
            $post->setBody(trim($_POST['body']));
            $post->setUserId($_SESSION['user_id']);
            $data = [
                'title_error' => '',
                'body_error' => ''
            ];

            //validate the title

            if(empty($_POST['title'])){
                $data['title_error'] = 'Please enter a title';
            }

            if(empty($_POST['body'])){
                $data['body_error'] = 'Please enter some text';
            }
            $data['body'] = $post->getBody();
            $data['title'] = $post->getTitle();



            $repositoryPost = new PostRepository();

            if(empty($data['title_error'])  && empty($data['body_error'])){
                if($repositoryPost->save($post)){
                    flash('post_message', 'Post added');
                    redirect('/post/index/index');

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

    public function edit($id) {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'id' => $id,
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
                if($this->postModel->updatePost($data)){
                    flash('post_message', 'Post updated');
                    redirect('/posts');
                } else {
                    die('There has been an error');
                }
            } else {
                $this->view('posts/edit', $data);
            }

        } else {
            //Get existing post form model
            $post = $this->postModel->getPostById($id);
            //Check ownership
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            $data = ["title" => $post->title,
                "body" => $post->body,
                'id' => $id
            ];

            $this->view('posts/edit', $data);
        }
    }

    public function show($id) {

        $RepositoryPost = new PostRepository();
        $result = $RepositoryPost->getById($id);

        $user = '1';

        $data = ['body' => $result->getBody(),
                'title' => $result->getTitle(),
                'id' => $result->getId(),
            'user' => $user,
            'created_at' => $result->getCreatedAt(),
            'user_id' => $result->getUserId()
        ];

        $this->view('posts/show', $data);
    }

    public function delete($id) {

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $RepositoryPost = new PostRepository();
            $post = $RepositoryPost->getById($id);

            $postid = $post->getUserId();
            var_dump($_SESSION['user_id']);

            if($postid != $_SESSION['user_id']){
                redirect('post/index/show/'.$id);
            }

            if($RepositoryPost->deleteById($id)){
                flash('post_message', 'Post removed successfully');
                redirect('posts');
            } else {
                die('Something has gone wrong');
            }

        }

        else
        {
            redirect('post/index/show/'.$id);
        }
    }
}