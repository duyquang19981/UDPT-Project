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
include_once '../../objects/report.php';

$database = new Database();
$db = $database->getConnection();

$category = new report($db);

$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "true", "categories" => []];

$stmt = $category->readAll();
$num = $stmt->rowCount();

if ($num > 0) {
  // products array
  $category = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);
    $category = array(
      "category_id" => $CATEGORY_ID,
      "mod_id" => $MOD_ID,
      "name" => $NAME,
      "status" => $STATUS,
      "created" => $CREATED,
    );

    array_push($res["categories"], $category);
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
