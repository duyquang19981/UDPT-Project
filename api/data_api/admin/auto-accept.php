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
include_once '../../objects/answer.php';
include_once '../../objects/question.php';

$database = new Database();
$db = $database->getConnection();

$question = new question($db);
$answer = new answer($db);

$badKeywords = file('../badkeywords.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$badKeywords = array_values(array_filter($badKeywords, "trim"));
$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "false"];
if (
  !empty($data->mod_id) &&
  !empty($data->accept_day)
) {
  $res =  ["result" => "true"];
  $stmt = $answer->readAcceptNo();
  $num = $stmt->rowCount();
  if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $isContainingBadKeyword = 0;
      if (empty($MOD_ID) && empty($ACCEPT_DAY)) {
        foreach ($badKeywords as $badKeyword) {
          if (strpos(strtolower($CONTENT), strtolower($badKeyword)) !== false) {
            $isContainingBadKeyword = 1;
            break;
          }
        }
        if ($isContainingBadKeyword === 0) {
          $answer->id_answer = $ID_ANSWER;
          $answer->mod_id = $data->mod_id;
          $answer->accept_day = $data->accept_day;
          $check = $answer->accept();
          if ($check != 1) {
            $res["result"] = "false";
            http_response_code(401);
            echo json_encode(array(
              "message" => "error",
              "res" => $res
            ));
            break;
          }
        } else continue;
      }
    }
  }

  $stmt = $question->readAcceptNo();
  $num = $stmt->rowCount();
  if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $isContainingBadKeyword = 0;
      if (empty($MOD_ID) && empty($ACCEPT_DAY)) {
        foreach ($badKeywords as $badKeyword) {
          if (strpos(strtolower($DESCRIPTION), strtolower($badKeyword)) !== false) {
            $isContainingBadKeyword = 1;
            break;
          }
        }
        if ($isContainingBadKeyword === 0) {
          $question->id_question = $ID_QUESTION;
          $question->mod_id = $data->mod_id;
          $question->accept_day = $data->accept_day;
          $check = $question->accept();
          if ($check != 1) {
            $res["result"] = "false";
            http_response_code(401);
            // tell the user
            echo json_encode(array(
              "message" => "error",
              "res" => $res
            ));
            break;
          }
        } else continue;
      }
    }
  }
  http_response_code(201);
  // tell the user
  echo json_encode(array(
    "message" => "done",
    "res" => $res
  ));
} else {
  http_response_code(400);
  echo json_encode(array(
    "message" => "Wrong input data",
  ));
}
