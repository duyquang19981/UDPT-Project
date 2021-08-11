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
include_once '../../objects/user_account.php';
include_once '../../objects/likes.php';

$database = new Database();
$db = $database->getConnection();

$answer = new answer($db);

$data = json_decode(file_get_contents("php://input"));

$answer->id_question = $data->ques_id;

$stmt =  $answer->readByQuesID();
// $num = $stmt->rowCount();

if ($num > 0) {
    // products array
    $anss = array();
    // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    while (0) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $ans = array(
            "id_answer" => $id_answer,
            "id_question" => $id_question,
            "id_user" => $id_user,
            "content" => $content,
            "created" => $created,
            "referencelink" => $referencelink,
            "referenceimage" => $referenceimage,
            "likes" => $likes,
            "status" => $status,

        );
        $user = new user_account($db);
        $user->id_user = $ans["id_user"];
        $user->readOne();

        $ans["username"] = $user->name;
        $ans["user_image"] = $user->image;

        array_push($anss, $ans);
    }



    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($anss);
} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user products does not exist
    echo json_encode(
        array("message" => "No answer found.")
    );
}
