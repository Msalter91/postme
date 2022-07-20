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
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        //TODO Nothing to prevent session fixation attacks here!
        redirect('pages/index/index');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userToCreate = new User();

            $data = [
                'name' => (trim($_POST['name'])),
                'email' => (trim($_POST['email'])),
                'password' => (trim($_POST['password'])),
                'confirm_password' => (trim($_POST['confirm_password'])),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter an email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = 'Email already in use';
                }
            }
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter a name';
            }
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password much be at least 6 characters';
            }
            if ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_error'] = 'Passwords do not match';
            }

            if (
                empty($data['email_error']) && empty($data['password_error']) &&
                empty($data['name_error']) && empty($data['confirm_password_error'])
            ) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are now registered');
                    redirect('user/users/login');
                } else {
                    throw new Exception('Failed to register - please try again');
                }
            } else {
                $this->view('users/register', $data);
            }
        } else {
            $user = new User();
            $this->view('users/register', $user);
        }
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter an email';
            }
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password much be at least 6 characters';
            }
            if ($this->userModel->findUserByEmail($data['email'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_error'] = 'Username and password do not match';
                    $this->view('users/login', $data);
                }
            } else {
                $data['email_error'] = 'No user Found';
            }

            if (!empty($data['email_error']) || !empty($data['password_error'])) {
                $this->view('users/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            $this->view('users/login', $data);
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
