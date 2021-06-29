<?php

class ForgotpassController
{
    public function index()
    { 
        $VIEW = "./app/views/forgotpass/forgotpass.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
    
    
    public function fogotpasspost()
    { 
        require_once "./app/core/callapi.php";
        require_once "./app/config.php";
        $callapi = new callapi();
        $data = [
            "messenger" => ""
        ];
        $rndno=rand(100000, 999999);
        $_SESSION['otp'] = $rndno;
        $_SESSION['email'] = $_REQUEST["email"];
        $user = [
            "email" => $_REQUEST["email"],
            "otp" => $rndno
        ];
        $_SESSION['user'] = $user;
        $response_ = $callapi->callAPI('POST', _API_ROOT.'SendOTP/sendotp.php', json_encode($user));
        if($response_["code"]>=400)
        {
            $data = [
                "messenger" => $response_["data"]["message"]
            ];
            
            $VIEW = "./app/views/forgotpass/forgotpass.phtml";
            require("./app/layouts/questionLayout.phtml");
        }
        else
        {
            $data = [
                "messenger" => $response_["data"]["message"]
            ];
            
            $VIEW = "./app/views/forgotpass/otp.phtml";
            require("./app/layouts/questionLayout.phtml");
        }
    }

    public function otppost()
    {
        if($_SESSION['otp'] == $_REQUEST["otpvalue"])
        {
            require_once "./app/core/callapi.php";
            require_once "./app/config.php";
            $callapi = new callapi();
            try {
                
                    unset($_SESSION['user']);
                    unset($_SESSION['otp']);

                    $VIEW = "./app/views/forgotpass/changepass.phtml";
                    require("./app/layouts/questionLayout.phtml");
            
                
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
                "messenger" => "OTP sai xin nhập lại"
            ];
             
            $VIEW = "./app/views/login/otp.phtml";
            require("./app/layouts/questionLayout.phtml");
        }
    }
    public function changepass()
    {
        require_once "./app/core/callapi.php";
        require_once "./app/config.php";
        $callapi = new callapi();
        $data = [
            "messenger" => ""
        ];

        $pass = $_REQUEST["password"];
        $repass = $_REQUEST["repassword"];
        if($pass != null)
        {
            if($repass != null)
            {
                if($pass == $repass)
                {
                    $user = [
                        "password"=>$pass,
                        "email"=> $_SESSION['email']
                    ];
                    $response_ = $callapi->callAPI('POST', _API_ROOT.'user_account/forgotpass.php', json_encode($user));
                    if($response_["code"]>=400)
                    {
                        $data = [
                            "messenger" => $response_["data"]["message"]
                        ];
                        
                        $VIEW = "./app/views/forgotpass/forgotpass.phtml";
                        require("./app/layouts/questionLayout.phtml");
                    }
                    else
                    {   
                        $data = [
                            "messenger" => $response_["data"]["message"]
                        ];
                        
                        $VIEW = "./app/views/login/login.phtml";
                        require("./app/layouts/questionLayout.phtml");
                    }
                }
                else
                {
                    $data = [
                        "messenger" => "Repassword không giống password"
                    ];
                    $VIEW = "./app/views/forgotpass/changepass.phtml";
                    require("./app/layouts/questionLayout.phtml");
                }
                
            }
            else
            {
                $data = [
                    "messenger" => "Xin nhập Repassword "
                ];
                $VIEW = "./app/views/forgotpass/changepass.phtml";
                require("./app/layouts/questionLayout.phtml");
            }
        }
        else
        {
            $data = [
                "messenger" => "Xin nhập Password"
            ];
            $VIEW = "./app/views/forgotpass/forgotpass.phtml";
            require("./app/layouts/questionLayout.phtml");
        }
    }
}
