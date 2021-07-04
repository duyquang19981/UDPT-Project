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
include_once '../../objects/admin.php';

$database = new Database();
$db = $database->getConnection();

$ad = new admin($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
$res = ["result" => "false"];
// make sure data is not empty
if (
    !empty($data->name) &&
    !empty($data->username) &&
    !empty($data->pass) &&
    !empty($data->role) &&
    !empty($data->notification_yes) &&
    !empty($data->status)
) {
    // set product property values
    $ad->name = $data->name;
    $ad->username = $data->username;
    $ad->pass = $data->pass;
    $ad->pass = password_hash($ad->pass, PASSWORD_DEFAULT);
    $ad->role = $data->role;
    $ad->notification_yes = $data->notification_yes;
    $ad->status = $data->status;

    $check = $ad->create();
    // create the product
    if ($check == 1) {
        $res["result"] = "true";

        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array(
            "message" => "Tạo tài khoản thành công",
            "res" => $res
        ));
    } else {
        if ($check == 2) {
            http_response_code(404);
            // tell the user
            echo json_encode(array(
                "message" => "Username đã tồn tại. Xin nhập Username khác!!",
                "res" => $res
            ));
        } else {
            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array(
                "message" => "Unable to create Account.",
                "res" => $res
            ));
        }
    }
} else {

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array(
        "message" => "Unable to create Account. Data is incomplete.",
        "res" => $res
    ));
}
