<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// generate json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;
// get database connection
include_once '../../config/database.php';
  
// instantiate product object
include_once '../../objects/admin.php';
include_once '../../objects/question.php';
include_once '../../objects/answer.php';
include_once '../../objects/notification.php';
include_once '../../objects/notification_admin.php';
$database = new Database();
$db = $database->getConnection();
  
$answer = new answer($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->id_answer) &&
    !empty($data->content) &&
    !empty($data->jwt)
){

    $answer->content = $data->content;
    $answer->referencelink = $data->referencelink;
    $answer->referenceimage = $data->referenceimage;
    $answer->id_answer = $data->id_answer;
    $jwt = $data->jwt;

    if($jwt){
 
        // if decode succeed, show user details
        try {
     
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            try {
                $check = $answer->update();
            if($check == 1)
            {
                http_response_code(200);
                    // tell the user
                echo json_encode(array(
                    "message" => "Update câu hỏi thành công"
                    
                ));
            }
            else
            {
                http_response_code(503);
                
                // tell the user
                echo json_encode(array("message" => "Unable to create question."));
            }
            }
            catch (Exception $e){
        
                // set response code
                http_response_code(404);
            
                // show error message
                echo json_encode(array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage(),
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
                "error" => $e->getMessage(),
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
}
else
{
     // set response code - 400 bad request
     http_response_code(400);
  
     // tell the user
     echo json_encode(array("message" => "Unable to create Question. Data is incomplete."));
}
  