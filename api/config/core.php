<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('_DIR_ROOT', __DIR__);
if (!empty($_SERVER['HTTPS']) && $_SERVER('HTTP') == "on") {
        $web_root = 'https://' . $_SERVER['HTTP_HOST'];
    } else {
        $web_root = 'http://' . $_SERVER['HTTP_HOST'];
    }
// home page url
$home_url= $web_root."/UDPT-Project/api/data_api/";
  
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$from_record_num = 1;
// show error reporting
error_reporting(E_ALL);
 
// set your default time-zone
date_default_timezone_set('Asia/Manila');
 
// variables used for jwt
$key = "example_key";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 hour
$issuer = "http://localhost/CodeOfaNinja/RestApiAuthLevel1/";

?>