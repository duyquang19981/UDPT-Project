<?php


class LoginController
{
    public function index()
    {     
        $VIEW = "./app/views/login/login.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
    public function loginpost() {
        require_once "./app/core/callapi.php";
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
                $response = $callapi->callAPI('PUT', 'http://localhost:8080/UDPT-Project/api/data_api/user_account/login.php', json_encode($user));
                if (isset($response["data"]["jwt"]))
                {
                    
                    $response1 = $callapi->callAPI('PUT', 'http://localhost:8080/UDPT-Project/api/data_api/validate_token.php', json_encode($response["data"]));
                    $user = [
                        "jwt" => $response["data"]["jwt"],
                        "id" => $response1["data"]["data"]["id"],
                        "username" => $response1["data"]["data"]["username"],
                        "name" => $response1["data"]["data"]["name"]
                    ];
                    
                    $this->createUserSession($user);
                   
                }
                else
                {
                    $data = [
                        "messenger" => $response["data"]["message"]
                    ];
                    $VIEW = "./app/views/login/login.phtml";
                    require("./app/layouts/questionLayout.phtml");
                };
                
              }
              catch (Exception $e) {
                $data = [
                            "messenger" => $e->getMessage()
                        ];
                $VIEW = "./app/views/login/login.phtml";
                require("./app/layouts/questionLayout.phtml");
              };
        }
        else
        {
            $data = [
                "messenger" => "Xin vui lòng điền username, password"
            ];
            $VIEW = "./app/views/login/login.phtml";
            require("./app/layouts/questionLayout.phtml");
        }

    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user["id"];
        $_SESSION['username'] = $user["haha"];
        $_SESSION['name'] = $user["name"];
        $_SESSION['jwt'] = $user["jwt"];
        header('location:'.'/UDPT-PROJECT');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['jwt']);
        header('location:'.'/UDPT-PROJECT/login');
    }
}
