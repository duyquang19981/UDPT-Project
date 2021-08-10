
<?php
define('_DIR_ROOT', __DIR__);
echo "   :  congif :     ";
//xu ly root
// if (!empty($_SERVER['HTTPS']) && $_SERVER('HTTP') == "on") {
//     $web_root = 'https://' . $_SERVER['HTTP_HOST'];
// } else {
//     $web_root = 'http://' . $_SERVER['HTTP_HOST'];
// }
$web_root = 'https://' . $_SERVER['HTTP_HOST'];
// $temp = str_replace("\\", "/", strtolower(_DIR_ROOT));
// $folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', $temp);

// $web_root = $web_root . $folder;
// $web_root = str_replace("/app", '', $web_root);


define('_WEB_ROOT', $web_root);

$public = _WEB_ROOT . '/public';
define('_PUBLIC', $public);

$api_url = _WEB_ROOT . "/api/data_api/";
define('_API_ROOT', $api_url);
// echo $api_url;


