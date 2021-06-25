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
        // require_once './app/core/PHPMailerAutoload.php';
        require_once "./app/core/class.phpmailer.php";
        require_once "./app/core/class.smtp.php";
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
                                
                                $mail = new PHPMailer;
                                $mail->SMTPOptions = [
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true,
                                    ]
                                ];
                                // $mail->SMTPDebug = 4;                               // Enable verbose debug output
                                $mail->CharSet = 'UTF-8';
                                $mail->Encoding = 'base64';
                                $mail->isSMTP();                                      // Set mailer to use SMTP
                                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                $mail->Username = 'tubato1999@gmail.com';                 // SMTP username
                                $mail->Password = 'quenmatroi1602';                           // SMTP password
                                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                                $mail->Port = 587;                                    // TCP port to connect to

                                $mail->setFrom('tubato1999@gmail.com', 'Mailer');
                                $mail->addAddress($user["email"], 'Joe User');     // Add a recipient
                                $mail->addReplyTo('tubato1999@gmail.com');


                                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                                $mail->isHTML(true);                                  // Set email format to HTML

                                $mail->Subject = 'Xác nhận mã OTP';
                                $mail->Body    = "Mã otp của bạn là:  <b>".$rndno."</b>";
                                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                                if(!$mail->send()) {
                                    $data = [
                                        "messenger" => "lỗi hệ thống"
                                    ];    
                                    break;
                                } else {
                                    header('location:'.'/UDPT-PROJECT/signup/otp');
                                    break;
                                }
                            }
                            
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

    function sendSMS($mobile, $otp) {
        // Account details
        $apiKey = urlencode('Your API key');
        // Message details
        $numbers = array($mobile);
        $sender  = urlencode('TXTLCL');
        $message = rawurlencode('Your One Time Password is '.$otp.' for verification your account.');
        $numbers = implode(',', $numbers);
      
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
  
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);      
        // Process your response here
        return $response;
     }
}
