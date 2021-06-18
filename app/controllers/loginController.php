<?php

class LoginController
{
    public function index()
    {
        $data = "Hello world !!!!";        
        $VIEW = "./app/views/login/login.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
    public function loginpost()
    {
        
    }
}
