<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
  
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/user_account.php';

  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$user = new user_account($db);
  
// set ID property of record to read
$user->id_user = isset($_GET['id_user']) ? $_GET['id_user'] : die();
  
// read the details of product to be edited
$user->readOne();
  
if($user->name!=null){
    // create array
    $user_arr = array(
        "name" => $user->name,
        "image" => $user->image,
        "email" => $user->email,
    );

    $user_arr["ques"] = $user->getnumques($user->id_user);
    $user_arr["answer"] = $user->getnumans($user->id_user);

    $stmt = $user->readAll();
    $num = $stmt->rowCount();
    $users = array();
    if ($num > 0) {
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $userss = array(
            "id_user" => $ID_USER,
            "name" => $NAME,
            "image"=> $IMAGE,
            "email" => $EMAIL,
            "birth" => $BIRTH,
            "phone" => $PHONE,
            "status" => $STATUS,
            "created" => $CREATED,
            
            );
            $month = date('m');
            $ques = 0;
            $ans = 0;
            $ques = $user->getnumquesInMonth($ID_USER, $month);
            $ans = $user->getnumansInMonth($ID_USER, $month);
            $userss['ques'] =  $ques;
            $userss['answer'] =  $ans;
            array_push($users, $userss);
        };
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

        for ($i = 0; $i < count($users); $i++)
        {
            if($users[$i]['id_user'] == $user->id_user)
            {
                $user_arr['top'] =  $i+1;
            }
        }
    }
        
    
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($user_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Product does not exist."));
}
?>