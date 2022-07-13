<?php

declare(strict_types=1);

use library\Controller as Controller;

class Index extends Controller
{
    public function index(): void
    {
        if (isLoggedIn()) {
            redirect('post/index/index');
        }

        $data = [
            'title' => 'Postme',
            'description' => 'Simple social network'
        ];

        $this->view('pages/index', $data);
    }

    public function about(): void
    {
        $data = [
            'title' => 'About',
            'description' => 'An app to share your posts'
        ];
        $this->view('pages/about', $data);
    }

    public function error(): void
    {
        $data = [];
        $this->view('pages/error', $data);
    }
}
