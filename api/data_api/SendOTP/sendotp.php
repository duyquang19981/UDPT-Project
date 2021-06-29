<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once "./class.phpmailer.php";
require_once "./class.smtp.php";

// set ID property of record to read
$data = json_decode(file_get_contents("php://input"));
  
// set product property values
$email = $data->email;
$rndno = $data->otp;
if($email != null)
{
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

    $mail->setFrom('tubato1999@gmail.com', 'Xác thực OTP');
    $mail->addAddress($email);     // Add a recipient
    $mail->addReplyTo('tubato1999@gmail.com');


    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Xác nhận mã OTP';
    $mail->Body    = '<div>
                        <table style="background-color:#161821;margin-top:20px;width:100%;border-spacing:0px">
                        <tbody>
                            <tr><td style="padding:20px 0px">
                            <div style="margin:auto;max-width:600px">
                                <table style="width:100%;border-spacing:0px;border-collapse:separate;padding-left:20px;padding-right:20px">
                                <tbody>
                                    <tr>
                                    <td style="background-color:#ffffff;border-top-right-radius:10px;border-top-left-radius:10px;padding:60px 20px;box-sizing:border-box;display:block;text-align:center">
                                        
                                        <img height="160" width="160" src="https://ci3.googleusercontent.com/proxy/_CHiCJsHZSpv8oFgS0Ibe7jk-VfjzyXpKjWpOfEcfvRVTa5y9JoOQ9pAYVPId3c6nkzE3Q5IDTlqdl12eSHQLcZ1TgMRI65VaAH4g9MGEWOutCt3Dgw=s0-d-e1-ft#https://storage.googleapis.com/axie-cdn/email-static/email-axie.png" class="CToWUd a6T" tabindex="0"><div class="a6S" dir="ltr" style="opacity: 0.01; left: 464px; top: 221px;"><div id=":3jd" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" title="Tải xuống" role="button" tabindex="0" aria-label="Tải xuống tệp đính kèm " data-tooltip-class="a1V"><div class="akn"><div class="aSK J-J5-Ji aYr"></div></div></div></div>
                                        <div style="margin-top:40px"></div>
                                        <h6 style="font-family:AvenirNext-Bold;font-size:20px;color:#a1a6b6;text-align:center;line-height:24px;margin:0px">
                                            Mã xác nhận
                                        </h6>
                                        <p style="font-family:AvenirNext-Bold;font-size:40px;color:#11131b;letter-spacing:0px;text-align:center;line-height:44px;margin:0px;margin-top:8px;letter-spacing:14px">
                                            '.$rndno.'
                                        </p>
                                        <div style="margin-top:32px"></div>
                                        <div style="width:40px;height:1px;margin:auto;background:#a1a6b6"></div>
                                        <div style="margin-top:32px"></div>
                                        <p style="font-family:AvenirNext-Medium;font-size:14px;color:#11131b;text-align:center;line-height:20px;margin:0px">
                                            Bạn đang tạo tài khoản tại trang web 
                                            <a href="http://localhost:8080/UDPT-PROJECT" style="color:#046cfc;text-decoration:none" target="_blank" >Question And Answer</a>
                                            <br>
                                        </p>
                    
                                    </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            </td></tr>
                        </tbody>
                        </table><div class="yj6qo"></div><div class="adL">
                    </div></div>';
    if(!$mail->send()) {
        http_response_code(404);
  
        // tell the user no products found
        echo json_encode(
            array("message" => "lỗi hệ thống")
        );   
    } else {
        http_response_code(200);

        echo json_encode(
            array("message" => "Gửi OTP thành công")
        ); 
    }
    
}




?>