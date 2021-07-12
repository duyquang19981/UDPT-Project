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
include_once '../../objects/tag.php';

$database = new Database();
$db = $database->getConnection();

$tag = new tag($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "false"];
// make sure data is not empty
if (
  !empty($data->mod_id) &&
  !empty($data->description) &&
  !empty($data->status)
) {
  $tag->mod_id = $data->mod_id;
  $tag->description = $data->description;
  $tag->status = $data->status;

  $check = $tag->create();

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
