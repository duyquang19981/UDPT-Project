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
include_once '../../objects/tag.php';
include_once '../../objects/ques_tag.php';
include_once '../../objects/notification.php';
include_once '../../objects/notification_admin.php';
$database = new Database();
$db = $database->getConnection();
  
$ques = new question($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->category_id) &&
    !empty($data->description) &&
    !empty($data->tags)&&
    !empty($data->jwt) &&
    !empty($data->ques_id)
){

    $ques->category_id = $data->category_id;
    $ques->description = $data->description;
    $ques->id_question = $data->ques_id;
    $tags = $data->tags;
    $jwt = $data->jwt;

    if($jwt){
 
        // if decode succeed, show user details
        try {
     
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            try {
            $check = $ques->update();
            if($check == 1)
            {
                $ques_tag = new ques_tag($db);
                $ques_tag->question_id = $ques->id_question;
                $oke = $ques_tag->drop();
                
                $tagss = explode(",",filter_var(trim($tags,",")));
                $nums = count($tagss);
                //t???o tag, ques_tag
                for ($i = 0; $i < $nums; $i++)
                {
                    $tag = new tag($db);
                    $tag ->description = $tagss[$i];
                    $tag ->status = 1;
                    $tag -> mod_id = 1;
                    $stmt = $tag->fillbydescription();
                    $num = $stmt->rowCount();
                    if($num>0)
                    {
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        $user_item=array(
                            "id_tag" => $id_tag
                        );
                        $tag ->id_tag = $user_item["id_tag"];

                        
                        $ques_tag->tag_id = $tag ->id_tag;
                        $temp2 = $ques_tag->create();
                        
                    }else
                    {
                        $temp = $tag->create();
                        $tem = $tag->fillbydescription();

                        $row = $tem->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        $user_item=array(
                            "id_tag" => $id_tag
                        );
                        $tag ->id_tag = $user_item["id_tag"];
                        $ques_tag->tag_id = $tag ->id_tag;
                        $temp1 = $ques_tag->create();
                    }
                }
                http_response_code(200);
                    // tell the user
                echo json_encode(array(
                    "message" => "Update c??u h???i th??nh c??ng"
                    
                ));

            }
            else
            {
                // set response code
                http_response_code(404);
                            
                // show error message
                echo json_encode(array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage(),
                ));
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
  