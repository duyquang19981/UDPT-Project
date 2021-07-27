<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../../config/database.php';

// instantiate product object
include_once '../../objects/mail_send.php';

$database = new Database();
$db = $database->getConnection();

// set ID property of record to read
$data = json_decode(file_get_contents("php://input"));


$email_send = new email_send($db);
$email_send->email = $data->email;
if($email_send->create())
{
    http_response_code(200);

    echo json_encode(
        array("message" => "Thêm email thành công")
    ); 
}
else
{
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "lỗi hệ thống")
    );  
}

