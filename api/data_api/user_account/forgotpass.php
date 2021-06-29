<?php
// required headers
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
  
// include database and object files
include_once '../../config/core.php';
include_once '../../shared/utilities.php';
include_once '../../config/database.php';
include_once '../../objects/user_account.php';

// generate json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new user_account($db);

// set ID property of record to read
$data = json_decode(file_get_contents("php://input"));
  
// set product property values
$user->email = $data->email;
$pass = $data->password;
$user->password = base64_encode($pass);
if($user->forgotpass()){
    // set response code
    http_response_code(200);
    
    // response in json format
    echo json_encode(
            array(
                "message" => "Cập nhật mật khẩu thành công"
            )
        );
}

// if unable to update the product, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "cập nhật mật khẩu thất bại. Xin vui lòng thử lại sau"));
}
?>