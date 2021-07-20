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
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
// read the details of product to be edited

if($user->get_maxid_user($id) == 1)
{
    $max =[
        "max" => true
    ]  ;
}
else
{
    $max =[
        "max" => false
    ]  ;
}
// set response code - 200 OK
http_response_code(200);

// make it json format
echo json_encode($max);

?>