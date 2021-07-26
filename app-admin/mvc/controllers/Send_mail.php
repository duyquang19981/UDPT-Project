<?php
class Send_mail extends Controller
{

    public function index()
    {
      $callapi = new callapi();
      $url =  _API_ROOT . "/sendmail/get_all_mail.php";
      $responseData =  $callapi->callAPI("GET", $url, 0);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        $data =  [
          "View" => "sendmail",
          "email" => $res["emails"],
        ];
        self::layout(
          "main",
          $data
        );
      }
    }
}?>