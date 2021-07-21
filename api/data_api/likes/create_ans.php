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
include_once '../../objects/likes.php';
include_once '../../objects/answer.php';
$database = new Database();
$db = $database->getConnection();
  
$likes = new likes($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if(
    !empty($data->owner_id) &&
    !empty($data->answer_id) &&
    !empty($data->jwt)
){

    $likes->owner_id = $data->owner_id;
    $likes->answer_id = $data->answer_id;
    $likes->created = date("Y-m-d h:i:s");
    $jwt = $data->jwt;

    if($jwt){
 
        // if decode succeed, show user details
        try {
     
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            try {
                $num = $likes->check_ans();
                if($num < 1)
                {
                    $check = $likes->create_ans();
                    if($check == 1)
                    {
                        $ans = new answer($db);
                        $ans->id_answer = $likes->answer_id;
                        $li = $ans->get_like();
                        $check1 = $ans->update_like($li+1);
                        if($check1 == 1)
                        {
                            http_response_code(200);
                            // tell the user
                            echo json_encode(array(
                            "message" => "Like câu hỏi thành công",
                            "check"=>1
                            
                        ));
                        }
                        else
                        {
                            http_response_code(503);
                            
                            // tell the user
                            echo json_encode(array("message" => "update like in question false."));
                        }
                        
                    }
                    else
                    {
                        http_response_code(503);
                        
                        // tell the user
                        echo json_encode(array("message" => "Unable to create like."));
                    }
                }
                else
                {
                    $check = $likes->delete_ans();
                    if($check == 1)
                    {
                        $ans = new answer($db);
                        $ans->id_answer = $likes->answer_id;
                        $li = $ans->get_like();
                        $check1 = $ans->update_like($li-1);

                        if($check1 == 1)
                        {
                            http_response_code(200);
                            // tell the user
                            echo json_encode(array(
                            "message" => "Dislike câu hỏi thành công",
                            "check"=>0
                            
                        ));
                        }
                        else
                        {
                            http_response_code(503);
                            
                            // tell the user
                            echo json_encode(array("message" => "update like in question false."));
                        }
                    }
                    else
                    {
                        http_response_code(503);
                        
                        // tell the user
                        echo json_encode(array("message" => "Unable to create dislike."));
                    }
                    
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
  