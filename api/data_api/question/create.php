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
include_once '../../objects/question.php';
include_once '../../objects/tag.php';
$database = new Database();
$db = $database->getConnection();
  
$ques = new question($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->category_id) &&
    !empty($data->description) &&
    !empty($data->owner_id) &&
    !empty($data->tags)&&
    !empty($data->jwt)
){

    $ques->category_id = $data->category_id;
    $ques->description = $data->description;
    $ques->created = date("Y-m-d h:i:s");
    $ques->owner_id = $data->owner_id;
    $tags = $data->tags;
    $jwt = $data->jwt;

    if($jwt){
 
        // if decode succeed, show user details
        try {
     
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $check = $ques->create();
            if($check == 1)
            {
                $id_ques = $ques->getIDafterCreate();
                $tag = explode(",",filter_var(trim($tags,",")));
                $num = count($tag);
                for ($i = 0; $i < $num; $i++)
                {
                    $tag = new tag($db);
                    
                }


                http_response_code(200);
                    // tell the user
                echo json_encode(array(
                    "message" => "Đặt câu hỏi thành công", 
                    "id"=>$id_ques,
                    "date" => $ques->created
                ));
            }
            else
            {
                http_response_code(503);
                
                // tell the user
                echo json_encode(array("message" => "Unable to create Account."));
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
     echo json_encode(array("message" => "Unable to create Account. Data is incomplete."));
}
  