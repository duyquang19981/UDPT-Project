<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/user_account.php';

// generate json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new user_account($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
 
// if jwt is not empty
if($jwt){
 
    // if decode succeed, show user details
    try {
 
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $id =  $decoded->data->id;
        $user->id_user = $data->id_user;
        if($id == $user->id_user)
        {
            // set product property values
            $user->name = $data->name;
            $user->email = $data->email;
            $user->phone = $data->phone;
            $user->birth = $data->birth;
            
            // update the product
            if($user->update()){
                // set response code
                http_response_code(200);
                
                // response in json format
                echo json_encode(
                        array(
                            "message" => "User was updated.",
                            "name"=>$user->name
                        )
                    );
            }
            
            // if unable to update the product, tell the user
            else{
            
                // set response code - 503 service unavailable
                http_response_code(503);
            
                // tell the user
                echo json_encode(array("message" => "Unable to update account."));
            }
        }
        else
        {
            // set response code
            http_response_code(401);
        
            // show error message
            echo json_encode(array(
                "message" => "Access denied.",
            ));
        }
            
    }
 
    // if decode fails, it means jwt is invalid
    catch (Exception $e){
    
        // set response code
        http_response_code(401);
    
        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}
 
// show error message if jwt is empty
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}
?>