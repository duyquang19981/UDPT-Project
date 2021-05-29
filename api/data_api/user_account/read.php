<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8mb4_unicode_ci");
  
// database connection will be here
// include database and object files
include_once '../../config/database.php';
include_once '../../objects/user_account.php';
  
// instantiate database and user_account object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$user = new user_account($db);
  
// read products will be here
// query products
$stmt = $user->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    
    // products array
    $user_arr=array();
    $user_arr["data"] = array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $user_item = array(
            "id_user" => $id_user,
            "name" => $name,
            "email" => $email,
            "birth" => $birth,
            "phone" => $phone,
            "created" => $created
        );
  
        array_push($user_arr["data"], $user_item);
        
    }

    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($user_arr,JSON_UNESCAPED_UNICODE);
}
  
// no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No USER_ACCOUNT found.")
    );
}
