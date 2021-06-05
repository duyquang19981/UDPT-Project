<?php

class SignupController
{
    public function index()
    {
        $data = "Hello world !!!!";        
        $VIEW = "./views/user/signup.phtml";
        require("./layouts/questionLayout.phtml");
    }
}
