<?php

class LoginController
{
    public function index()
    {
        $data = "Hello world !!!!";        
        $VIEW = "./views/user/login.phtml";
        require("./layouts/questionLayout.phtml");
    }
}
