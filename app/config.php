<?php
define('_DIR_ROOT', __DIR__);
if (!empty($_SERVER['HTTPS']) && $_SERVER('HTTP') == "on") {
        $web_root = 'https://' . $_SERVER['HTTP_HOST'];
    } else {
        $web_root = 'http://' . $_SERVER['HTTP_HOST'];
    }
    $web_root1 = $web_root ."/UDPT-Project/api/data_api/" ;
    define('_API_ROOT', $web_root1);
    define('_Web_ROOT',$web_root."/UDPT-Project");
?>