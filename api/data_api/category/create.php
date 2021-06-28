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
include_once '../../objects/category_ques.php';

$database = new Database();
$db = $database->getConnection();

$category = new category_ques($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "false"];
// make sure data is not empty
if (
  !empty($data->name) &&
  !empty($data->mod_id) &&
  !empty($data->created) &&
  !empty($data->status)
) {
  $category->name = $data->name;
  $category->mod_id = $data->mod_id;
  $category->created = $data->created;
  $category->status = $data->status;

  $check = $category->create();

  if ($check == 1) {
    $res["result"] = "true";
    http_response_code(201);
    // tell the user
    echo json_encode(array(
      "message" => "done",
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
    "message" => "Wrong input data",
    // "res" => $res
  ));
}
