<?php

declare(strict_types=1);

use library\Controller as Controller;

class Users extends Controller

{
    protected ?object $userModel = null;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function createUserSession(User $user)
    {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getName();
        session_regenerate_id(true);
        redirect('pages/index/index');
    }


    public function register(): void
    {
        $errors = [
            'name_error' => '',
            'email_error' => '',
            'password_error' => '',
            'confirm_password_error' => ''
        ];


        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $user = new User();
            $this->view('users/register', $user, $errors);
            return;
        }

        $userToCreate = new User();

        if (empty($_POST['email'])) {
            $errors['email_error'] = 'Please enter an email';
        }

        $repositoryUser = new UserRepository();

        if (empty($_POST['name'])) {
            $errors['name_error'] = 'Please enter a name';
        }
        if (empty($_POST['password'])) {
            $errors['password_error'] = 'Please enter a password';
        } elseif (strlen($_POST['password']) < 6) {
            $errors['password_error'] = 'Password much be at least 6 characters';
        }
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errors['confirm_password_error'] = 'Passwords do not match';
        }
        $isExistingUser = $repositoryUser->getByEmail($_POST['email']);
        if (!empty($isExistingUser->getEmail())) {
            $errors['email_error'] = 'Email linked to another account';
        }
        if (
            !empty($errors['email_error']) || !empty($errors['password_error']) ||
            !empty($errors['name_error']) || !empty($errors['confirm_password_error'])
        ) {
            $this->view('users/register', $userToCreate, $errors);
            return;
        } else {
            $userToCreate->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $userToCreate->setName($_POST['name']);
            $userToCreate->setEmail($_POST['email']);

            try {
                $repositoryUser->save($userToCreate);
                flash('register_success', 'You are now registered');
                redirect('user/users/login');
            } catch (Exception $e) {
                throw new Exception('Failed to register - please try again');
            }
        }
    }

    public function login(): void
    {
        $errors = [
            'name_error' => '',
            'email_error' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $user = new User();
            $this->view('users/login', $user, $errors);
            return;
        }
        $userToLogin = new User();

        if (empty($_POST['email'])) {
            $errors['email_error'] = 'Please enter an email';
        }
        if (empty($_POST['password'])) {
            $errors['password_error'] = 'Please enter a password';
        } elseif (strlen($_POST['password']) < 6) {
            $errors['password_error'] = 'Password much be at least 6 characters';
        }

        if (!empty($errors['email_error']) || !empty($errors['password_error'])) {
            $this->view('users/login', $userToLogin, $errors);
            return;
        }

        $userToLogin->setEmail($_POST['email']);
        $userToLogin->setPassword($_POST['password']);

        $repositoryUser = new UserRepository();

        try {
            $result = $repositoryUser->getByEmail($userToLogin->getEmail());
        } catch (Exception $e) {
            $errors['email_error'] = $e->getMessage();
            $this->view('users/login', $userToLogin, $errors);
            return;
        }

        if (password_verify($userToLogin->getPassword(), $result->getPassword())) {
            $this->createUserSession($result);
        } else {
            $errors['password_error'] = 'Username and password do not match';
            $this->view('users/login', $userToLogin, $errors);
        }
        if (!empty($errors['password_error'])) {
            $this->view('users/login', $userToLogin, $errors);
        }
    }

    public function logout(): void
    {
        unset($_SERVER['user_id']);
        unset($_SERVER['user_name']);
        unset($_SERVER['user_email']);
        session_destroy();
        redirect('/User/Users/login');
    }
}
