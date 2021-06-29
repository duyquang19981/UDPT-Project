<?php

class userProfileController
{
    public function index($id)
    {   
        require_once "./app/core/callapi.php";
        $callapi = new callapi();
        // $response_ = $callapi->callAPI('POST', _API_ROOT.'user_account/forgotpass.php', json_encode($user));

        $VIEW = "./app/views/user/userProfile.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
    
}
