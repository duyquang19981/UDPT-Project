<?php

class LoginController
{
    public function index()
    {   
         
        $VIEW = "./app/views/login/login.phtml";
        require("./app/layouts/loginLayout.phtml");
    }
    public function loginpost() {
        require_once "./app/core/callapi.php";
        require_once "./app/config.php";
        $callapi = new callapi();
        $data = [
            "messenger" => ""
        ];
        if (isset($_REQUEST["username"]))
        {
            $user = [
                "username" => $_REQUEST["username"],
                "password" => $_REQUEST["password"],
            ];
            try {
                $response = $callapi->callAPI('PUT', _API_ROOT.'user_account/login.php', json_encode($user));
                if (isset($response["data"]["jwt"]))
                {
                    
                    $response1 = $callapi->callAPI('PUT', _API_ROOT.'validate_token.php', json_encode($response["data"]));
                    $user = [
                        "jwt" => $response["data"]["jwt"],
                        "id" => $response1["data"]["data"]["id"],
                        "email" => $response1["data"]["data"]["email"],
                        "name" => $response1["data"]["data"]["name"],
                        "image" => $response1["data"]["data"]["image"]
                    ];
                    
                    $this->createUserSession($user);
                   
                }
                else
                {
                    $data = [
                        "messenger" => $response["data"]["message"]
                    ];
                     
                    $VIEW = "./app/views/login/login.phtml";
                    require("./app/layouts/loginLayout.phtml");
                };
                
              }
              catch (Exception $e) {
                $data = [
                            "messenger" => $e->getMessage()
                        ];
                 
                $VIEW = "./app/views/login/login.phtml";
                require("./app/layouts/loginLayout.phtml");
              };
        }
        else
        {
            $data = [
                "messenger" => "Xin vui lòng điền username, password"
            ];
             
            $VIEW = "./app/views/login/login.phtml";
            require("./app/layouts/loginLayout.phtml");
        }

    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user["id"];
        $_SESSION['username'] = $user["haha"];
        $_SESSION['name'] = $user["name"];
        $_SESSION['email'] = $user["email"];
        $_SESSION['image'] = $user["image"];
        $_SESSION['jwt'] = $user["jwt"];

        header('location:'._WEB_ROOT);
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['image']);
        unset($_SESSION['jwt']);
        header('location:'. _WEB_ROOT.'/login');
    }
}
