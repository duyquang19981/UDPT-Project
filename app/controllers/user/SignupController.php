<?php

class SignupController
{
    public function index()
    {
        $data = "Hello world !!!!";        
        $VIEW = "./app/views/user/login/signup.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
}
