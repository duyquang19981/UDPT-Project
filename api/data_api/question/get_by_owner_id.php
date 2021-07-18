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
include_once '../../objects/question.php';
include_once '../../objects/tag.php';
include_once '../../objects/category_ques.php';
$database = new Database();
$db = $database->getConnection();

$question = new question($db);

$data = json_decode(file_get_contents("php://input"));

$id = $data->owner_id;

$stmt = $question->getlist($id);
$num = $stmt->rowCount();

if ($num > 0) {
  // products array
  $questions = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);
    $question = array(
      "id_question" => $ID_QUESTION,
      "owner_id" => $OWNER_ID,
      "category_id" => $CATEGORY_ID,
      "description" => $DESCRIPTION,
      "mod_id" => $MOD_ID,
      "likes" => $LIKES,
      "created" => $CREATED,
      "status" => $STATUS,
      
    );
    $question["tags"] = array();

    array_push($questions, $question);
  }

  for ($i = 0; $i < count($questions); $i++)
  {
    $tag = new tag($db);
    $temp = $tag->getbyquesid($questions[$i]["id_question"]);
    $tags = array();
    while ($row = $temp->fetch(PDO::FETCH_ASSOC)) {
      // extract row
      // this will make $row['name'] to
      // just $name only
      extract($row);
      $tag = array(
        "DESCRIPTION" => $DESCRIPTION,
      );
  
      array_push($questions[$i]["tags"],$tag);
    }
    $cate = new category_ques($db);
    $questions[$i]["category_id"] = $cate ->getNamebyid($questions[$i]["category_id"]);

  }

  $res["result"] = "true";
  http_response_code(201);
  // tell the user
  echo json_encode(array(
    "message" => "done",
    "res" => $questions
  ));
} else {
  http_response_code(201);

  echo json_encode(array(
    "message" => "No record",
    "res" => $res
  ));
}


