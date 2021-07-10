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
include_once '../../objects/answer.php';

$database = new Database();
$db = $database->getConnection();

$answer = new answer($db);

$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "true", "answers" => []];

$stmt = $answer->readAll();
$num = $stmt->rowCount();

if ($num > 0) {
  // products array
  $answer = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);
    $answer = array(
      "id_answer" => $ID_ANSWER,
      "id_question" => $ID_QUESTION,
      "id_user" => $ID_USER,
      "mod_id" => $MOD_ID,
      "content" => $CONTENT,
      "created" => $CREATED,
      "accept_day" => $ACCEPT_DAY,
      "status" => $STATUS,
    );

    array_push($res["answers"], $answer);
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
