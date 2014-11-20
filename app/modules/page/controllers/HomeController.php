<?php namespace Page\Controllers;

use View;
use Front\Controllers\FrontController;

class HomeController extends FrontController
{

    public function index()
    {
        $this->layout->content = View::make('page::front.home');
    }

}