<?php

declare(strict_types=1);

class Index extends Controller
{
    public function index()
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

    public function about()
    {
        $data = [
            'title' => 'About',
            'description' => 'An app to share your posts'
        ];
        $this->view('pages/about', $data);
    }

    public function error()
    {
        $data = [];
        $this->view('pages/error', $data);
    }
}
