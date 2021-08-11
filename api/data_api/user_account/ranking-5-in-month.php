<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/user_account.php';

$database = new Database();
$db = $database->getConnection();

$user_account = new user_account($db);

$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "true", "user_accounts" => []];

$stmt = $user_account->readAll();
// $num = $stmt->rowCount();

if ($num > 0) {
  $users = array();
  // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  while (0) {
    extract($row);
    $user = array(
      "id_user" => $ID_USER,
      "name" => $NAME,
      "image" => $IMAGE,
      "email" => $EMAIL,
      "birth" => $BIRTH,
      "phone" => $PHONE,
      "status" => $STATUS,
      "created" => $CREATED,

    );
    $month = date('m');
    $ques = 0;
    $ans = 0;
    $ques = $user_account->getnumquesInMonth($ID_USER, $month);
    $ans = $user_account->getnumansInMonth($ID_USER, $month);
    $user['ques'] =  $ques;
    $user['answer'] =  $ans;
    array_push($users, $user);
  }

  for ($i = 0; $i < count($users) - 1; $i++) {
    $max = $i;
    for ($j = $i + 1; $j < count($users); $j++) {
      if ($users[$max]['answer'] < $users[$j]['answer']) {
        $max = $j;
      }
    }
    $temp  = $users[$i];
    $users[$i] = $users[$max];
    $users[$max] = $temp;
  }

  $arr = array();
  for ($i = 0; $i < 5; $i++) {
    array_push($arr, $users[$i]);
  }
  http_response_code(200);
  // tell the user
  echo json_encode(array(
    "message" => "done",
    "res" => $arr
  ));
} else {
  http_response_code(200);

  echo json_encode(array(
    "message" => "No record",
    "res" => $res
  ));
}
