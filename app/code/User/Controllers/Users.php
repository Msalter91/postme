<?php

declare(strict_types=1);


class Users extends Controller

{
    protected ?object $userModel = null;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function createUserSession($user){
        //TODO Writing strings (poss 255 chars) to three session variables will be slow! Can this be replaced with a Bool?
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        //TODO Nothing to prevent session fixation attacks here!
        redirect('pages/index/index');
    }

    public function register(){

        //Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $userToCreate = new User();

            $data=[
                'name' => (trim($_POST['name'])),
                'email' => (trim($_POST['email'])),
                'password' => (trim($_POST['password'])),
                'confirm_password' => (trim($_POST['confirm_password'])),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            //Validate Fields
            if(empty($data['email'])){
                $data['email_error'] = "Please enter an email";
            } else {
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = "Email already in use";
                }
            }
            if(empty($data['name'])){
                $data['name_error'] = "Please enter a name";
            }
            if(empty($data['password'])){
                $data['password_error'] = "Please enter a password";
            } elseif (strlen($data['password']) < 6 ) {
                $data['password_error'] = "Password much be at least 6 characters";
            }
            if($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_error'] = 'Passwords do not match';
            }

            if(empty($data['email_error']) && empty($data['password_error']) && empty($data['name_error']) && empty($data['confirm_password_error'])) {

                //Hash the password

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register the user using the Model

                if($this->userModel->register($data)){
                    flash('register_success', 'You are now registered');
                    redirect('user/users/login');
                } else {
                    die('Something has gone wrong');
                }

            } else {
                // Reloads the view with errors
                $this->view('users/register', $data);
            }

        } else {
            // Load the form
            // Initialise the data

            $user = new User();

            $errors=[
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];
            $this->view('users/register', $user);
        }
    }

    public function login(){

        //Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process the form

            $data=[
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];

            //Validate Fields
            if(empty($data['email'])){
                $data['email_error'] = "Please enter an email";
            }
            if(empty($data['password'])){
                $data['password_error'] = "Please enter a password";
            } elseif (strlen($data['password']) < 6 ) {
                $data['password_error'] = "Password much be at least 6 characters";
            }

            if($this->userModel->findUserByEmail($data['email'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser){
                    //Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_error'] = 'Username and password do not match';
                    // Reloads the view with errors
                    $this->view('users/login', $data);
                }
            } else {
                //No User exists
                $data['email_error'] = 'No user Found';
            }

            if(!empty($data['email_error']) || !empty($data['password_error'])) {
                $this->view('users/login', $data);
            }
        } else {
            // Load the form
            // Initialise the data
            $data=[
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            $this->view('users/login', $data);
        }
    }

    public function logout() {
        //TODO If these aren't used specifically - replace with simple Boolean
        unset($_SERVER['user_id']);
        unset($_SERVER['user_name']);
        unset($_SERVER['user_email']);
        session_destroy();
        redirect('/User/Users/login');
    }

}