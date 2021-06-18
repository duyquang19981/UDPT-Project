<?php

class LoginController
{
    public function index()
    {
        $data = "Hello world !!!!";        
        $VIEW = "./app/views/user/login/login.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
}
