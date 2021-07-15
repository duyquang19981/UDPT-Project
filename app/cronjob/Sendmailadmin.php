<?php
require_once "../core/callapi.php";
require_once "../config.php";
$callapi = new callapi();
$user = [
  "email" => "tubato1999@gmail.com"
];
$response1 = $callapi->callAPI('POST', _API_ROOT.'sendmail/mailCheck.php', json_encode($user));

?>