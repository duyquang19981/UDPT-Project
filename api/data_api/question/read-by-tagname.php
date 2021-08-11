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
  !empty($data->tagname)
) {
  // echo $data->tagname;
  $tagname = array("DESCRIPTION" =>  $data->tagname);

  $stmt = $question->readAcceptedAndNotDeleted();
  $num = count($stmt);
  if ($num > 0) {
    foreach ($stmt as $row) {
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
        "tags" => []
      );
      $cate = new category_ques($db);
      $ques["category_name"] = $cate->getNamebyid($ques["category_id"]);

      $tag = new tag($db);
      $temp = $tag->getbyquesid($ques["id_question"]);
      $tags = array();
      // while ($row = $temp->fetch(PDO::FETCH_ASSOC)) {
      while (0) {
        extract($row);
        $tag = array(
          "DESCRIPTION" => $DESCRIPTION,
        );
        array_push($ques["tags"], $tag);
      }
      // print_r($ques["tags"]);
      if (in_array($tagname, $ques["tags"])) {
        $answer = new answer($db);
        $answer->id_question =  $ques["id_question"];
        $stmt1 =  $answer->readByQuesID();
        $ques["comment"] = count($stmt1);

        array_push($res["questions"], $ques);
      }
    }


    $res["result"] = "true";
    $res["tagname"] = $data->tagname;
    http_response_code(200);
    // tell the user
    echo json_encode(array(
      "message" => "done",
      "res" => $res
    ));
  } else {
    http_response_code(200);

    echo json_encode(array(
      "message" => "No record",
      "res" => $res
    ));
  }
} else {
  echo "No input Data";
}
