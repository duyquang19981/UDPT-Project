<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
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
include_once '../../objects/answer.php';
include_once '../../objects/user_account.php';
include_once '../../objects/likes.php';

$database = new Database();
$db = $database->getConnection();

$answer = new answer($db);

$data = json_decode(file_get_contents("php://input"));

$answer->id_user = $data->id_user;
$jwt = $data->jwt;
if($jwt){
 
    // if decode succeed, show user details
    try {
 
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        try {
            $stmt =  $answer->readByUserID();
            $num = $stmt->rowCount();
            if ($num > 0) {
                // products array
                $anss = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    // this will make $row['name'] to
                    // just $name only
                    extract($row);
                    $ans = array(
                    "id_answer" => $id_answer,
                    "id_question" => $id_question,
                    "id_user" => $id_user,
                    "content" => $content,
                    "created" => $created,
                    "referencelink" => $referencelink,
                    "referenceimage" => $referenceimage,
                    "likes" => $likes,
                    "status" => $status,
                    "mod_id" =>$mod_id
                    
                    );
                    $user = new user_account($db);
                    $user->id_user = $ans["id_user"];
                    $user->readOne();

                    $ans["username"] = $user->name;
                    $ans["user_image"] = $user->image;

                    array_push($anss, $ans );
                }



                // set response code - 200 OK
                http_response_code(200);
            
                // make it json format
                echo json_encode($anss);

            }else{
            
                // set response code - 404 Not found
                http_response_code(404);
            
                // tell the user products does not exist
                echo json_encode(
                    array("message" => "No answer found.")
                );
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


