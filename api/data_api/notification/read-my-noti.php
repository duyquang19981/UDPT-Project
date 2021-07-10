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
include_once '../../objects/notification_admin.php';


$database = new Database();
$db = $database->getConnection();


// find the notifications of admin
// find in notification_admin to get all id_noti of admin
// from all of id_noti retrieved above, get noti content

$notification_admin = new notification_admin($db);
$notification = new notification($db);

$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->admin_id)
) {
  $notification_admin->admin_id = $data->admin_id;
  $data = json_decode(file_get_contents("php://input"));
  $res =  ["result" => "true", "notifications" => []];

  $stmt = $notification_admin->readMyNoti();
  $num = $stmt->rowCount();

  if ($num > 0) {
    $noti_admin = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      extract($row);
      $noti_admin = array(
        "id_na" => $ID_NA,
        "noti_id" => $NOTI_ID,
        "admin_id" => $ADMIN_ID,
        "status" => $STATUS,
      );
      $notification->id_noti = $NOTI_ID;
      $getNotiRow =  $notification->getById();
      $noti_admin["notification"] = NULL;
      while ($notiRow = $getNotiRow->fetch(PDO::FETCH_ASSOC)) {
        extract($notiRow);
        $noti = array(
          "id_noti" => $ID_NOTI,
          "id_question" => $ID_QUESTION,
          "id_answer" => $ID_ANSWER,
          "content" => $CONTENT,
          "created"  => $CREATED
        );
        $noti_admin["notification"] = $noti;
      }
      array_push($res["notifications"], $noti_admin);
    }

    $res["result"] = "true";
    http_response_code(201);
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
  echo " No admin id";
}
