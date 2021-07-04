<?php
define('_DIR_ROOT', __DIR__);

//xu ly root
if (!empty($_SERVER['HTTPS']) && $_SERVER('HTTP') == "on") {
  $web_root = 'https://' . $_SERVER['HTTP_HOST'];
} else {
  $web_root = 'http://' . $_SERVER['HTTP_HOST'];
}
$temp = str_replace("\\", "/", strtolower(_DIR_ROOT));
$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', $temp);
$web_root = $web_root . $folder;

define('_WEB_ROOT', $web_root);

$public = _WEB_ROOT . '/public';
define('_PUBLIC', $public);

$containerFolder = $web_root . "/..";
define('_CONTAINER_FOLDER', $containerFolder);

$current_admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$indexOfReplaceString = strpos($current_admin_url, "app-admin");

$api_url = substr_replace($current_admin_url, "api/data_api", $indexOfReplaceString);
define('_API_ROOT', $api_url);
