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
include_once '../../objects/question.php';
include_once '../../objects/answer.php';
include_once '../../objects/tag.php';
include_once '../../objects/category_ques.php';

$database = new Database();
$db = $database->getConnection();

$question = new question($db);

$data = json_decode(file_get_contents("php://input"));
$res =  ["result" => "true", "questions" => []];


if (
  !empty($data->category_id) &&
  !empty($data->page)
) {
  $question->category_id = $data->category_id;
  $question->offset = ($data->page - 1) * $question->limit;

  $stmt = $question->readByCategoryId();
  $num = $stmt->rowCount();
  if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $ques = array(
        "id_question" => $ID_QUESTION,
        "owner_id" => $OWNER_ID,
        "category_id" => $CATEGORY_ID,
        "mod_id" => $MOD_ID,
        "description" => $DESCRIPTION,
        "likes" => $LIKES,
        "created" => $CREATED,
        "accept_day" => $ACCEPT_DAY,
        "status" => $STATUS,
        "comment" => 0,
        "tags" =>[]
      );
      $cate = new category_ques($db);
      $ques["category_name"] = $cate->getNamebyid($ques["category_id"]);

      $tag = new tag($db);
      $temp = $tag->getbyquesid($ques["id_question"]);
      $tags = array();
      while ($row = $temp->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $tag = array(
          "DESCRIPTION" => $DESCRIPTION,
        );

        array_push($ques["tags"], $tag);
      }

      $answer = new answer($db);
      $answer->id_question =  $ques["id_question"];
      $stmt1 =  $answer->readByQuesID();
      $ques["comment"] = $stmt1->rowCount();

      array_push($res["questions"], $ques);
    }

    $stmt = $question->countByCategoryId();
    $totalQues = $stmt->fetch(PDO::FETCH_ASSOC);
    $res["totalPages"] = ceil($totalQues["COUNT(*)"] / $question->limit);

    $res["result"] = "true";
    http_response_code(201);
    // tell the user
    echo json_encode(array(
      "message" => "done",
      "res" => $res
    ));
  } else {
    $stmt = $question->countByCategoryId();
    $total = $stmt->fetch(PDO::FETCH_ASSOC);
    $res["totalPages"] = $total["COUNT(*)"];
    http_response_code(201);

    echo json_encode(array(
      "message" => "No record",
      "res" => $res
    ));
  }
} else {
  echo "No input Data";
}
