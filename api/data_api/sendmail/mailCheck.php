<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once "../SendOTP/class.phpmailer.php";
require_once "../SendOTP/class.smtp.php";
include_once '../../config/database.php';
include_once '../../objects/question.php';
include_once '../../objects/mail_send.php';
$num = 0;
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$ques = new question($db);
$num = $ques->countQuesCheck() - 3;
if ($num >0)
{
    $text = 'Còn '. $num .' câu hỏi nữa...';
}
else
{
    $text = "";
}
$last = '
</tbody>
    </table>
    </td>
    <td width="16" style="display:block;width:16px">
    &nbsp;&nbsp;&nbsp;</td>
    </tr>

    <tr>
    <td width="16" style="display:block;width:16px">
    &nbsp;&nbsp;&nbsp;</td>
    <td>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tbody>
    <tr>
    <td style="padding:0;color:#65676b;text-align:left;width:100%;font-size:15px;font-weight:400;font-family:Roboto-Regular,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif">
        '.$text.'
    </td>
    </tr>
    <tr>
    <td height="0" style="line-height:0px">
        &nbsp;</td>
    </tr>
    <tr>
    <td align="middle">
        <a href="" style="color:#3b5998;text-decoration:none" target="_blank">
            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                <tbody>
                    <tr>
                        <td style="border-collapse:collapse;border-radius:6px;text-align:center;display:block;border:none;background:#e4e6eb;padding:5px 20px 8px 20px">
                            <center>
                                <font size="3">
                                    <span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;white-space:nowrap;font-weight:bold;vertical-align:middle;color:#050505;font-size:17px;font-weight:500;font-family:Roboto-Medium,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif;font-size:15px">Duyệt các câu hỏi ngay</span>
                                </font>
                            </center>
                        </td>
                    </tr>
                </tbody>
            </table>
        </a>
    </td>
    </tr>
    <tr>
    <td height="8" style="line-height:8px">
        &nbsp;</td>
    </tr>
    <tr>
    <td height="40" style="line-height:40px">
        &nbsp;</td>
    </tr>
    </tbody>
    </table>
    </td>
    <td width="16" style="display:block;width:16px">
    &nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
    <td width="16" style="display:block;width:16px">
    &nbsp;&nbsp;&nbsp;</td>
    <td>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tbody>
    <tr>
    <td style="font-family:Roboto-Regular,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif;font-size:11px;color:#8a8d91;line-height:16px;font-weight:400">
        <span class="m_-3729033916094481730mb_text" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823;font-family:Roboto-Regular,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif;font-size:11px;color:#8a8d91;line-height:16px;font-weight:400">
        Vui lòng không chuyển tiếp email này để bảo vệ tài khoản của bạn an toàn.
            </span>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    <td width="16" style="display:block;width:16px">
    &nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
    <td height="20" style="line-height:20px" colspan="3">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
</tbody>
</table>

</table>
<div class="yj6qo"></div>
<div class="adL">


</div>
</div>';
$body = '';
$arr = $ques->get3quesCheck();

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
$mail->Username = 'nguyenphamanhtu99@gmail.com';                 // SMTP username
$mail->Password = 'tuthao1610';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
foreach ($arr as $temp) {
    
    // if($temp[1]!= null)
    // {
    //     $mail->AddEmbeddedImage('http://localhost:8080'.$temp[1], 'logo_2u'.$temp[3]);;
    // }
    $body = $body.'<!-- thông tin câu hỏi -->
    <tr>
        <td>
            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                <tbody>
                    <tr>
                        <td style="font-size:11px;font-family:Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                                <tbody>
                                    <tr>
                                        <td style="padding:0;color:#65676b;text-align:left;width:100%;font-size:15px;font-weight:400;font-family:Roboto-Regular,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif">
                                            '.$temp[4].'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="12" style="line-height:12px">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size:11px;font-family:Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="font-size:11px;font-family:Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif;background:#ffffff;border:solid 1px #e4e6eb;border-radius:6px;padding:16px;display:block">
                                                                            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td valign="top">
                                                                                            <a href="" style="color:#3b5998;text-decoration:none" target="_blank">
                                                                                                <img src="https://ci3.googleusercontent.com/proxy/_CHiCJsHZSpv8oFgS0Ibe7jk-VfjzyXpKjWpOfEcfvRVTa5y9JoOQ9pAYVPId3c6nkzE3Q5IDTlqdl12eSHQLcZ1TgMRI65VaAH4g9MGEWOutCt3Dgw=s0-d-e1-ft#https://storage.googleapis.com/axie-cdn/email-static/email-axie.png" width="90" height="90" style="border:solid 1px rgba(0,0,0,0.15);border-radius:50%" class="CToWUd"></a>
                                                                                        </td>
                                                                                        <td width="12" style="display:block;width:12px">
                                                                                            &nbsp;&nbsp;&nbsp;
                                                                                        </td>
    
                                                                                        <td width="100%">
                                                                                            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="left">
                                                                                                            <span class="m_-3729033916094481730mb_text" style="color:#050505;font-size:16px;line-height:19px;font-weight:500;font-family:Roboto-Medium,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif">'
                                                                                                            .$temp[0].
                                                                                                            '</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td height="2" style="line-height:2px">
                                                                                                            &nbsp;
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td align="left">
                                                                                                            <span class="m_-3729033916094481730mb_text" style="font-family:Roboto-Regular,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px;line-height:18px;color:#65676b;font-weight:400">23
                                                                                                                tuổi</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td height="8" style="line-height:8px">
                                                                                                            &nbsp;
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            '.$temp[2].'
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <!-- hết thông tin câu hỏi -->
    <tr>
        <td height="20" style="line-height:20px">
            &nbsp;</td>
    </tr>
    <!-- hết thông tin câu hỏi -->';
    };
$mail->setFrom('nguyenphamanhtu99@gmail.com', 'Admin Web Question and Answer');

$mails = new email_send($db);

$stmt = $mails->get_all();
$num = $stmt->rowCount();

if ($num > 0) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $ans = array(
            "email" => $email          
            
            );
        $mail->addAddress($ans["email"]); 
    }
    $mail->addReplyTo('nguyenphamanhtu99@gmail.com');


    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->isHTML(true);                                  // Set email format to HTML
    $time = new DateTime();
    $mail->Subject = 'Kiểm duyệt câu hỏi ngày: '.date('d-m-Y');
    $mail->Body    = '<div style="background-color:#161821;margin-top:20px;width:100%;border-spacing:0px;padding:2%">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin-top: 2%;margin-bottom: 2%;">
        <table border="0" cellspacing="0" cellpadding="0" align="center" id="m_-3729033916094481730email_table" style="border-collapse:collapse;max-width:420px;margin:0 auto">
            <tbody>

                <tr>
                    <td id="m_-3729033916094481730email_content" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;background:#ffffff">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                            <tbody>
                                <tr>
                                    <td width="16" style="display:block;width:16px">
                                        &nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                                            <tbody>
                                                <tr>
                                                    <td height="20" style="line-height:20px">
                                                        &nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="m_-3729033916094481730mb_text" style="color:#050505;font-size:16px;line-height:20px;font-weight:400;font-family:Roboto-Regular,Roboto,-apple-system,BlinkMacSystemFont,Helvetica Neue,Helvetica,Arial,sans-serif">
                                                            Hôm nay bạn cần kiểm tra các câu hỏi sau:
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="20" style="line-height:20px">
                                                        &nbsp;</td>
                                                </tr> '.$body." ". $last ;
    if(!$mail->send()) {
        http_response_code(404);

        // tell the user no products found
        echo json_encode(
            array("message" => "lỗi hệ thống")
        );   
    } else {
        http_response_code(200);

        echo json_encode(
            array("message" => "Gửi mail thành công")
        ); 
    }
}
else
{
    http_response_code(404);

        // tell the user no products found
        echo json_encode(
            array("message" => "Không có email")
        );   
}

    





?>