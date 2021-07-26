<?php
class Report extends Controller
{

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Report/Read');
  }

  public function Read()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/Report/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "report",
        "Reports" => $res["reports"],
      ];
      self::layout(
        "main",
        $data
      );
    }
  }


}
