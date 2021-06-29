<?php
class Notification extends Controller
{
  public $AdminModel;

  public function __construct()
  {
    $this->AdminModel = $this->model("AdminModel");
  }

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Home');
  }

  public function TurnOn()
  {
    if (isset($_POST["submitToggleFormBtn"])) {
      $id_admin = $_POST["id_admin"];
      $requestData = [
        "id_admin" =>  $id_admin
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/admin/turn-on-notification.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        Session::set('notification_yes', 1);
      }
      header('Location:' . _WEB_ROOT . '/Home');
    } else {
      header('Location:' . _WEB_ROOT . '/Home');
    }
  }

  public function TurnOff()
  {
    if (isset($_POST["submitToggleFormBtn"])) {
      $id_admin = $_POST["id_admin"];
      $requestData = [
        "id_admin" =>  $id_admin
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/admin/turn-off-notification.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        Session::set('notification_yes', 0);
      }
      //Show result
      header('Location:' . _WEB_ROOT . '/Home');
    } else {
      header('Location:' . _WEB_ROOT . '/Home');
    }
  }
}
