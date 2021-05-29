<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
  
// database connection will be here
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/admin.php';
  
// instantiate database and user_account object
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new admin($db);
  
// set ID property of record to read
$data = json_decode(file_get_contents("php://input"));
  
// set product property values
$user->username = $data->username;
$user->pass = $data->pass;

 $user->login(); 

// generate json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;
 
// check if email exists and if password is correct
if($user->id_admin!=null)
{
 
    $token = array(
       "iat" => $issued_at,
       "exp" => $expiration_time,
       "iss" => $issuer,
       "data" => array(
           "id" => $user->ID_ADMIN,
           "username" => $user->USERNAME
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "token" => $jwt
            )
        );
 
}
 
// login failed
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Đăng nhập thất bại!! Tên đăng nhập hoặc mật khẩu sai!"));
}
?>