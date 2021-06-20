<?php

class SignupController
{
    public function index()
    {   
        $data = [
            "messenger" => ""
        ];
        $VIEW = "./app/views/login/signup.phtml";
        require("./app/layouts/questionLayout.phtml");
    }

    public function signuppost()
    {
        require_once "./app/core/callapi.php";
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
                    require_once "./app/core/callapi.php";
                    $callapi = new callapi();
                    try {
                        $response = $callapi->callAPI('PUT', 'http://localhost:8080/UDPT-Project/api/data_api/user_account/checksignup.php', json_encode($user));
                        if($response["code"]>=400)
                        {
                            $data = [
                                "messenger" => $response["data"]["message"]
                            ];
                            $VIEW = "./app/views/login/signup.phtml";
                            require("./app/layouts/questionLayout.phtml");
                        }else
                        {
                            $_SESSION['user'] = $user;
                            {
                                $rndno=rand(100000, 999999);
                                $_SESSION['otp'] = $rndno;
                                // require_once './app/core/class.phpmailer.php';
                                // $mail = new PHPMailer;
                                // $mail->IsSMTP();
                                // $mail->Host = 'smtpout.secureserver.net';
                                // $mail->Port = '80';
                                // $mail->SMTPAuth = true;
                                // $mail->Username = 'tubato1999@gmail.com';					
                                // $mail->Password = 'quenmatroi1610';
                                // $mail->SMTPSecure = '';
                                // $mail->From = 'tubato1999@gmail.com';
                                // $mail->FromName = 'Webslesson';
                                // $mail->AddAddress($user["email"]);
                                // $mail->WordWrap = 50;
                                // $mail->IsHTML(true);
                                // $mail->Subject = 'Verification code for Verify Your Email Address';
                                // $message_body = '
                                // <p>For verify your email address, enter this verification code when prompted: <b>'.$rndno.'</b>.</p>
                                // <p>Sincerely,</p>
                                // ';
                                // $mail->Body = $message_body;
            
                                // if($mail->Send())
                                // {
                                //     echo "haha";
                                //     // echo '<script>alert("Please Check Your Email for Verification Code")</script>';
                                //     // echo '<script>window.location.replace("email_verify.php?code='.$rndno.'");</script>';
                                // }

                            }
                            header('location:'.'/UDPT-PROJECT/signup/otp');
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
    public function otp()
    {
        $VIEW = "./app/views/login/otp.phtml";
        require("./app/layouts/questionLayout.phtml");
    }
    public function otppost()
    {
        if($_SESSION['otp'] == $_REQUEST["otpvalue"])
        {
            require_once "./app/core/callapi.php";
            $callapi = new callapi();
            try {
                $user = $_SESSION['user'];
                $response = $callapi->callAPI('POST', 'http://localhost:8080/UDPT-Project/api/data_api/user_account/create.php', json_encode($user));
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
