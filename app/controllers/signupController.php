<?php

class SignupController
{
    public function index()
    {   
         
        $VIEW = "./app/views/login/signup.phtml";
        require("./app/layouts/questionLayout.phtml");
    }

    public function signuppost()
    {
        require_once "./app/core/callapi.php";
        require_once "./app/config.php";
        $callapi = new callapi();
        $data = [
            "messenger" => ""
        ];
        $check = $this->checknull();
        switch ($check)
        {
            case 0:
                {
                    $user = [
                        "username" => $_REQUEST["username"],
                        "password" => $_REQUEST["password"],
                        "repassword" => $_REQUEST["repassword"],
                        "name" => $_REQUEST["name"],
                        "email" => $_REQUEST["email"],
                        "birth" => $_REQUEST["birth"],
                        "phone" => $_REQUEST["phone"],
                    ];
                    try {
                        $rndno=rand(100000, 999999);
                        $_SESSION['otp'] = $rndno;
                        $email_ = [
                            "email"=> $user["email"],
                            "otp" => $rndno
                        ];
                        // kiểm tra tài khoản đã tòn tại chưa
                        $response = $callapi->callAPI('PUT', _API_ROOT.'user_account/checksignup.php', json_encode($user));
                        if($response["code"]>=400)
                        {
                            $data = [
                                "messenger" => $response["data"]["message"]
                            ];
                             
                            $VIEW = "./app/views/login/signup.phtml";
                            require("./app/layouts/questionLayout.phtml");
                        }else
                        {
                            // gửi otp qua email
                            $_SESSION['user'] = $user;
                            $response_ = $callapi->callAPI('POST', _API_ROOT.'SendOTP/sendotp.php', json_encode($email_));
                            if($response_["code"]>=400)
                            {
                                $data = [
                                    "messenger" => $response_["data"]["message"]
                                ];
                                
                                $VIEW = "./app/views/login/signup.phtml";
                                require("./app/layouts/questionLayout.phtml");
                            }
                            else
                            {
                                $data = [
                                    "messenger" => $response_["data"]["message"]
                                ];
                                
                                $VIEW = "./app/views/login/otp.phtml";
                                require("./app/layouts/questionLayout.phtml");
                            }
                            break;
                        }
                        
                    }
                    catch (Exception $e) {
                        $data = [
                                    "messenger" => $e->getMessage()
                                ];
                         
                        $VIEW = "./app/views/login/login.phtml";
                        require("./app/layouts/questionLayout.phtml");
                        break;
                    };
                }
            // trả lỗi chưa nhập đủ thông tin
            case 1:
                {
                    $data = [
                        "messenger" => "Xin vui lòng điền đầy đủ thông tin"
                    ];
                     
                    $VIEW = "./app/views/login/signup.phtml";
                    require("./app/layouts/questionLayout.phtml");
                    break;
                }
            // trả lỗi repassword sai
            case 2:
                {
                    $data = [
                        "messenger" => "Repassword nhâp không giống password"
                    ];
                     
                    $VIEW = "./app/views/login/signup.phtml";
                    require("./app/layouts/questionLayout.phtml");
                    break;
                }
            // trả lỗi email sai cú pháp
            case 3:
                {
                    break;
                    $data = [
                        "messenger" => "email không đúng định dạng"
                    ];
                     
                    $VIEW = "./app/views/login/signup.phtml";
                    require("./app/layouts/questionLayout.phtml");
                }
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
                $user = $_SESSION['user'];
                $response = $callapi->callAPI('POST', _API_ROOT.'user_account/create.php', json_encode($user));
                if($response["code"]>=400)
                {
                    $data = [
                        "messenger" => $response["data"]["message"]
                    ];
                 
                $VIEW = "./app/views/login/signup.phtml";
                require("./app/layouts/questionLayout.phtml");
                }else
                {
                    unset($_SESSION['user']);
                    unset($_SESSION['otp']);
                    header('location:'.'/UDPT-PROJECT/login');
                }
                
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

    public function checknull()
    {
        if(!isset($_REQUEST["name"]) || $_REQUEST["name"] == null)
        {
            echo "1";
            return 1;
        }
        else
        {
            if(!isset($_REQUEST["username"]) || $_REQUEST["username"] == "")
            {
                echo "2";
                return 1;
            }
            else
            {
                if(!isset($_REQUEST["password"]) || $_REQUEST["password"] == "")
                {
                    echo "3";
                    return 1;
                }
                else
                {
                    if(!isset($_REQUEST["repassword"]) || $_REQUEST["repassword"] == "")
                    {
                        echo "4";
                        return 1;
                    }
                    else
                    {
                        if($_REQUEST["password"] != $_REQUEST["repassword"] )
                        {
                            echo "5";
                            return 2;
                        }
                        else
                        {
                            if(!isset($_REQUEST["email"]) || $_REQUEST["email"] == "")
                            {
                                echo "6";
                                return 1;
                            }
                            else
                            {
                                if(!isset($_REQUEST["birth"]) || $_REQUEST["birth"] == "")
                                {
                                    echo "9";
                                    return 1;
                                }
                                else
                                {
                                    if(!isset($_REQUEST["phone"])|| $_REQUEST["phone"] == "")
                                    {
                                        echo "10";
                                        return 1;
                                    }
                                    else{
                                        return 0;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    
}
