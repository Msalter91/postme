<?php

class Pages extends Controller
{
    public function __construct() {

    }

    public function index() {
        $data =  ['title'=> 'Stranger'];

        $this->view('pages/index', $data);


    }

    public function about() {
        // Added default argument here to prevent error from an incorrect url
        $data =  ['title'=> 'about'];
        $this->view('pages/about', $data);
    }
}