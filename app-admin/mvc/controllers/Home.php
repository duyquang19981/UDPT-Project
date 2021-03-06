<?php

class Home extends Controller
{

  public  function Default()
  {
    $data =  [
      "View" => "home",
    ];
    self::layout(
      "main",
      $data
    );
  }

  public function ChangePassword()
  {
    $data =  [
      "View" => "change-password",
    ];
    self::layout(
      "main",
      $data
    );
  }

  public function SubmitChangePassword()
  {
    if (isset($_POST["submitChangePW"])) {
      $id_admin = $_POST["id_admin"];
      $password = $_POST["password"];
      $requestData = [
        "id_admin" =>  $id_admin,
        "pass" => $password,
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/admin/change-password.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      self::layout("main", [
        "View"  => "change-password",
        "res" => $res
      ]);
    } else {
      self::layout("main", [
        "View"  => "change-password"
      ]);
    }
  }

  public function AutoAccept()
  {
    $mod_id = Session::get("admin-id");
    $today = date("Y-m-d");

    $requestData = [
      "mod_id" => trim($mod_id),
      "accept_day" => $today
    ];
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/admin/auto-accept.php";
    $responseData =  $callapi->callAPI("POST", $url, $requestData);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] == "false") {
      echo "alert('Khong thanh cong')";
    }
    header('Location:' . _WEB_ROOT . '/Question/Read');
  }

  public function Export()
  {
    $data =  [
      "View" => "export",
    ];
    self::layout(
      "main",
      $data
    );
  }
}
