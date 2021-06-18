<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
  
// instantiate product object
include_once '../../objects/user_account.php';
  
$database = new Database();
$db = $database->getConnection();
  
$user = new user_account($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->phone) &&
    !empty($data->birth) &&
    !empty($data->username) &&
    !empty($data->password) 
){
  
    // set product property values
    $user->name = $data->name;
    $user->email = $data->email;
    $user->phone = $data->phone;
    $user->birth = $data->birth;
    $user->username = $data->username;
    $user->password = $data->password;
    $user->created = date('Y-m-d');
    $user->password = base64_encode($user->password);
    
    $check = $user->create();
    // create the product
    if($check == 1){
  
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Tạo tài khoản thành công"));
    }
    else
    {
        if($check == 2)
        {
            http_response_code(404);
            // tell the user
            echo json_encode(array("message" => "Username đã tồn tại. Xin nhập Username khác!!"));
        }
        else
        {
            if($check == 3)
            {
                http_response_code(404);
                // tell the user
                echo json_encode(array("message" => "Email đã tồn tại. Xin nhập Email khác!!"));
            }
            else
            {
                if($check == 4)
                {
                    http_response_code(404);
  
                    // tell the user
                    echo json_encode(array("message" => "Phone đã tồn tại. Xin nhập Phone khác!!"));
                }
                else
                {
                    
                // set response code - 503 service unavailable
                http_response_code(503);
        
                // tell the user
                echo json_encode(array("message" => "Unable to create Account."));
                }
            }
        }
        
    }
  
    
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create Account. Data is incomplete."));
}
?>