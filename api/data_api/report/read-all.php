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

$report = new report($db);

$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "true", "reports" => []];

$stmt = $report->readAll();
$num = $stmt->rowCount();

if ($num > 0) {
  // products array
  $report = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);
    $report = array(
      "id_report" => $ID_REPORT,
      "id_owner" => $ID_OWNER,
      "id_question" => $ID_QUESTION,
      "reason" => $REASON,
      "created" => $CREATED,
    );

    array_push($res["reports"], $report);
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
