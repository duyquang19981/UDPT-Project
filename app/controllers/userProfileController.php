<?php

class userProfileController
{
    public function index()
    {   
        $VIEW = "./app/views/user/userProfile.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
    
}
