<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../../config/database.php';

// instantiate product object
include_once '../../objects/admin.php';

$database = new Database();
$db = $database->getConnection();

$admin = new admin($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
$res = ["result" => "false"];
if (!empty($data->id_admin)) {
  $admin->id_admin = $data->id_admin;
  $check = $admin->turnOnNotification();
  // create the product
  if ($check == true) {
    $res["result"] = "true";
    // set response code - 201 created
    http_response_code(201);
    // tell the user
    echo json_encode(array(
      "message" => "Done",
      "res" => $res
    ));
  } else {
    http_response_code(503);

    echo json_encode(array(
      "message" => "Error",
      "res" => $res
    ));
  }
} else {
  http_response_code(400);
  echo json_encode(array(
    "message" => "No input data",
    "res" => $res
  ));
}
