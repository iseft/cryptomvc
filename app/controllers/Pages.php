<?php

class Pages extends Controller {

public function __construct()
{
    $this->userModel = $this->model('User');
}

public function index() {

    $slogans = [['h1' =>'Crypto', 'h2' => 'sets you free.'], ['h1' =>'Money', 'h2' => 'sets you free.'], ['h1' =>'Money', 'h2' => 'is freedom.'], ['h1' =>'Crypto', 'h2' => 'is freedom...']];

    $actualSlogan = $slogans[array_rand($slogans)];

    $data = [
        'title' => 'Home page',
        'h1' => $actualSlogan['h1'],
        'h2' => $actualSlogan['h2'],
    ];

    $this->view('pages/index', $data);
}

public function portfolio() {

    

    $this->view('pages/portfolio');
}

}