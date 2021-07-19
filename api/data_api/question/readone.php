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
include_once '../../objects/user_account.php';
include_once '../../objects/category_ques.php';
include_once '../../objects/tag.php';

$database = new Database();
$db = $database->getConnection();

$question = new question($db);

$data = json_decode(file_get_contents("php://input"));

$id = $data->id_check;
$question-> id_question = $id;
$stmt = $question->read_one();

if($question->owner_id!=null){
    // create array
    $ques = array(
        "id_question" =>  $question->id_question,
        "owner_id" => $question->owner_id,
        "category_id" => $question->category_id,
        "description" => $question->description,
        "likes" => $question->likes,
        "status" => $question->status,
        "created" => $question->created
  
    );
    
    $cate = new category_ques($db);
    $ques["category_name"] = $cate ->getNamebyid($ques["category_id"]);

    
    $user = new user_account($db);
    $user->id_user = $ques["owner_id"];
    $user->readOne();

    $ques["username"] = $user->name;
    $ques["user_image"] = $user->image;

    $ques["tags"] = array();

    
    $tag = new tag($db);
    $temp = $tag->getbyquesid($ques["id_question"]);
    $tags = array();
    while ($row = $temp->fetch(PDO::FETCH_ASSOC)) {
      // extract row
      // this will make $row['name'] to
      // just $name only
      extract($row);
      $tag = array(
        "DESCRIPTION" => $DESCRIPTION,
      );
  
      array_push($ques["tags"],$tag);
    }
   

    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($ques);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Ques does not exist."));
}
?>






