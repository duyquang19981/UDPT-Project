<?php
// include_once '../../config/core.php';
// include_once '../../libs/php-jwt/src/BeforeValidException.php';
// include_once '../../libs/php-jwt/src/ExpiredException.php';
// include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
// include_once '../../libs/php-jwt/src/JWT.php';
// use \Firebase\JWT\JWT;
// database connection will be here
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/user_account.php';
// instantiate database and user_account object
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new user_account($db);

$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
$path = '../../../image/'; // upload directory
if( $_FILES['fileupload'])
{
    $img = $_FILES['fileupload']['name'];
    $tmp = $_FILES['fileupload']['tmp_name'];
    $jwt = $_POST['jwt'];
    $id_user = $_POST['id_user'];
    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    // can upload same image using rand function
    $final_image = rand(1000,1000000).$img;     
    // check's valid format
    if(in_array($ext, $valid_extensions)) 
    { 
        $path = $path.strtolower($final_image); 
        if(move_uploaded_file($tmp,"$path")) 
        {
            $image = "/UDPT-PROJECT/image/".$final_image;
            if($user->updateAvata($id_user,$image))
            {
                http_response_code(200);
                // response in json format
                echo json_encode(
                    array(
                        "message" => "User avatar was updated."
                    )
                );
            }
            else
            {
                http_response_code(500);
                // response in json format
                echo json_encode(
                    array(
                        "message" => "User avatar update false."
                    )
                );
            }
            
        }
    }
    else
    {
        http_response_code(400);
        // response in json format
        echo json_encode(
                array(
                    "message" => "error",
                )
            );
    }
}
?>