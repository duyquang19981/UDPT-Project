<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
  
// include database and object files
include_once '../../config/core.php';
include_once '../../shared/utilities.php';
include_once '../../config/database.php';
include_once '../../objects/user_account.php';

// generate json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;
  
// utilities
$utilities = new Utilities();
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$user = new user_account($db);

$page=isset($_GET["page"]) ? $_GET["page"] : "";
if($page <0)
{
    $page = 1;
}
$from_record_num = 0;
if ($page > 1)
{
    $from_record_num = ($page-1)*$records_per_page;
}
$stmt = $user->readPaging($from_record_num, $records_per_page );
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $user_arr=array();
    $user_arr["data"]=array();
    $user_arr["paging"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $user_item=array(
            "id_user" => $id_user,
            "name" => $name,
            "email" => $email,
            "birth" => $birth,
            "phone" => $phone,
            "status" => $status,
            "created" => $created
        );
  
        array_push($user_arr["data"], $user_item);
    }
  
  
    // include paging
    $total_rows=$user->count();
    $page_url="{$home_url}user_account/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page);
    $user_arr["paging"]=$paging;
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($user_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user products does not exist
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>