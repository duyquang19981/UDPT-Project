<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
  
// include database and object files
include_once '../../config/core.php';
include_once '../../config/database.php';
include_once '../../shared/utilities.php';
include_once '../../objects/user_account.php';

// generate json web token
include_once '../../config/core.php';
include_once '../../libs/php-jwt/src/BeforeValidException.php';
include_once '../../libs/php-jwt/src/ExpiredException.php';
include_once '../../libs/php-jwt/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt/src/JWT.php';
use \Firebase\JWT\JWT;
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
$utilities = new Utilities();
// initialize object
$user = new user_account($db);
  
// get keywords
$keywords=isset($_GET["name"]) ? $_GET["name"] : "";
$records_per_page = 10;
// query products
$stmt = $user->search($keywords,$from_record_num, $records_per_page);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $user_arr=array();
    $user_arr["data"]=array();
  
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
            "phone" => $phone,
            "email" => $email,
            "birth" => $birth,
            "created" => $created
        );
  
        array_push($user_arr["data"], $user_item);
    }
  
    $total_rows=$user->searchcount($keywords);
    $page_url="{$home_url}user_account/search.php?s={$keywords}&"  ;
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $user_arr["paging"]=$paging;

    
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data
    echo json_encode($user_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>