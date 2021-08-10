<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

// database connection will be here\
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/admin.php';

// generate json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';


// instantiate database and user_account object
$database = new Database();
$db = $database->getConnection();

$admin = new admin($db);
$requestData = json_decode(file_get_contents("php://input"));

$admin->username = $requestData->username;
$requestPassword = $requestData->pass;
$admin->getByUsername();
$res = ["result" => "false"];
// check if email exists and if password is correct
if ($admin->id_admin != null) {
    $_password = $admin->pass;
    //check password
    if (password_verify($requestPassword, $_password)) {
        $res['data'] =  $admin;
        $res["result"] = "true";
        http_response_code(200);
        $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                "id" => $admin->id_admin,
                "username" => $admin->username,
                "name" => $admin->name
            )
        );

        echo json_encode(
            array(
                "message" => "Successful login.",
                "res" => $res
            )
        );
    } else {
        http_response_code(401);
        echo json_encode(
            array(
                "message" => "Đăng nhập thất bại!! Tên đăng nhập hoặc mật khẩu sai!",
                "res" => $res
            )
        );
    }
} else {
    http_response_code(401);
    echo json_encode(
        array(
            "message" => "Đăng nhập thất bại!! Tên đăng nhập hoặc mật khẩu sai!",
            "res" => $res
        )
    );
}
