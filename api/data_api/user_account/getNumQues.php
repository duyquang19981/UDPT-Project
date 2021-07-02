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
$user = new user_account($db);

$id_user = isset($_GET['id_user']) ? $_GET['id_user'] : die();

$ques = 0;
$ans = 0;    
$ques = $user->getnumques($id_user);
$ans = $user->getnumans($id_user);
$user_arr = [
    "ques" => $ques,
    "answer" => $ans
];
http_response_code(200);
// make it json format

echo json_encode($user_arr);



?>