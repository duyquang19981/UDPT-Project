<?php
define('_DIR_ROOT', __DIR__);

//xu ly root
// print_r($_SERVER);
// if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
//   $web_root = 'https://' . $_SERVER['HTTP_HOST'];
// } else {
//   $web_root = 'http://' . $_SERVER['HTTP_HOST'];
// }

$web_root = 'https://' . $_SERVER['HTTP_HOST'];
// $temp = str_replace("\\", "/", strtolower(_DIR_ROOT));
// $folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', $temp);
$folder = '/app-admin';
$web_root = $web_root . $folder;

define('_WEB_ROOT', $web_root);

$public = _WEB_ROOT . '/public';
define('_PUBLIC', $public);

// $containerFolder = $web_root . "/..";
// define('_CONTAINER_FOLDER', $containerFolder);

// $current_admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// $indexOfReplaceString = strpos($web_root, "app-admin");

// $api222 = substr_replace($web_root, "api/data_api", 22);
$api_url = str_replace("app-admin", "api/data_api",$web_root);
// $api_url = _WEB_ROOT . '/api/data_api';
define('_API_ROOT', $api_url);
