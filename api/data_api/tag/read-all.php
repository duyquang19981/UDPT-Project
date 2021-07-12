<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../../config/database.php';

// instantiate product object
include_once '../../objects/tag.php';

$database = new Database();
$db = $database->getConnection();

$tag = new tag($db);

$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "true", "tags" => []];

$stmt = $tag->readAll();
$num = $stmt->rowCount();

if ($num > 0) {
  // products array
  $tag = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);
    $tag = array(
      "id_tag" => $ID_TAG,
      "mod_id" => $MOD_ID,
      "description" => $DESCRIPTION,
      "status" => $STATUS,
    );

    array_push($res["tags"], $tag);
  }

  $res["result"] = "true";
  http_response_code(201);
  // tell the user
  echo json_encode(array(
    "message" => "done",
    "res" => $res
  ));
} else {
  http_response_code(201);

  echo json_encode(array(
    "message" => "No record",
    "res" => $res
  ));
}
