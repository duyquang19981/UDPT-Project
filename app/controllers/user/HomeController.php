<?php

class HomeController
{
    public function index()
    {      
        $VIEW = "./app/views/user/home.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
}
