<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
  
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/user_account.php';

  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new user_account($db);
  
// set ID property of record to read
$user->id_user = isset($_GET['id_user']) ? $_GET['id_user'] : die();
  
// read the details of product to be edited
$user->readOne();
  
if($user->name!=null){
    // create array
    $user_arr = array(
        "id_user" =>  $user->id_user,
        "name" => $user->name,
        "image" => $user->image,
        "email" => $user->email,
        "birth" => $user->birth,
        "phone" => $user->phone,
        "created" => $user->created
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($user_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Product does not exist."));
}
?>