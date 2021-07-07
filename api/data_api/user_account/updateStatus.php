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
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new user_account($db);
  
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
$user->id_user = $data->id_user;
$user->status = $data->status;
// update the product
if($user->updatestatus()){
    // set response code
    http_response_code(200);
    
    // response in json format
    echo json_encode(
            array(
                "message" => "User status was updated."
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
    
        



?>