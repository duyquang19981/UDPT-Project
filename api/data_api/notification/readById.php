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
include_once '../../objects/notification.php';

$database = new Database();
$db = $database->getConnection();

$notification = new notification($db);

$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "true", "notifications" => []];

if (
  !empty($data->id_check)
) {
  $notification->id_noti = $data->id_check;
  $stmt = $notification->getById();
  $num = $stmt->rowCount();

  if ($num > 0) {
    $notification = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $notification = array(
        "id_noti" => $ID_NOTI,
        "id_question" => $ID_QUESTION,
        "id_answer" => $ID_ANSWER,
        "content" => $CONTENT,
        "created"  => $CREATED
      );

      array_push($res["notifications"], $notification);
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
} else {
  echo "No input Data";
}
