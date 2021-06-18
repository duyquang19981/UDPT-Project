<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");

// database connection will be here
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/user_account.php';
// instantiate database and user_account object
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new user_account($db);
  
// set ID property of record to read
$data = json_decode(file_get_contents("php://input"));
  
// set product property values
$user->username = $data->username;
$user->password = $data->password;
$user->password = base64_encode($user->password);

include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;

$user->login(); 
// read the details of product to be edited
if($user->id_user!=null){
    
    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "id" => $user->id_user,
            "username" => $user->username,
            "name" => $user->name
        )
     );
  
     // set response code
     http_response_code(200);
  
     // generate jwt
     $jwt = JWT::encode($token, $key);
     echo json_encode(
             array(
                 "message" => "Đăng nhập thành công",
                 "jwt" => $jwt
             )
         );
}
  
// no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Đăng nhập thất bại!! Tên đăng nhập hoặc mật khẩu sai!")
    );
}
