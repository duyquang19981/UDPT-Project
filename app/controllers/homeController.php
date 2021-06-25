<?php

class HomeController
{
    public function index()

    {     
        $VIEW = "./app/views/home.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
}
