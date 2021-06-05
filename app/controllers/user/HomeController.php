<?php

class HomeController
{
    public function index()
    {      
        $VIEW = "./views/user/home.phtml";
        require("./layouts/questionLayout.phtml");
    }
}
