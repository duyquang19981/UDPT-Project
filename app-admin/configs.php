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
