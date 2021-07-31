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
    !empty($data->id_question) &&
    !empty($data->id_user) &&
    !empty($data->content) &&
    !empty($data->jwt)
){

    $answer->id_question = $data->id_question;
    $answer->id_user = $data->id_user;
    $answer->content = $data->content;
    $answer->referencelink = $data->referencelink;
    $answer->referenceimage = $data->referenceimage;
    $answer->created = date("Y-m-d h:i:s");
    $jwt = $data->jwt;

    if($jwt){
 
        // if decode succeed, show user details
        try { 
     
            // decode jwt
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            try {
                $check = $answer->create();
            if($check == 1)
            {
                $id_ans = $answer->getIDafterCreate();
                
                // tạo thông báo cho admin
                $noti = new notification($db);
                $noti->id_answer = $id_ans;
                $noti->content = "Câu trả lời từ người dùng " .$answer->id_user.": ".$answer->content;
                $noti->created = date("Y-m-d h:i:s");
                $check1 = $noti->create_ans();
                // lấy id thông báo mới tạo
                $noti_id = $noti->getid_byanser();

                //lấy danh sách admin nhận thông báo
                $admin = new admin($db);
                $list_admin = $admin->get_id_admin_noti();
                $user_arr=array();
                $user_arr["data"]=array();
                while ($row = $list_admin->fetch(PDO::FETCH_ASSOC)){
                    
                    extract($row);
            
                    $user_item=array(
                        "id_admin" => $id_admin,
                    );
            
                    array_push($user_arr["data"], $user_item);
                }

                //tạo thông báo cho từng admin
                for ($i = 0; $i < count($user_arr["data"]); $i++)
                {
                    $admin_noti = new notification_admin($db);
                    $admin_noti->admin_id =  $user_arr["data"][$i]["id_admin"];
                    $admin_noti->noti_id = $noti_id;
                    $admin_noti->status = 1;
                    $tenn = $admin_noti->create();
                }
                http_response_code(200);
                    // tell the user
                echo json_encode(array(
                    "message" => "Trả lời câu hỏi thành công"
                    
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
  