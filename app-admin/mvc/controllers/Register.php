<?php
class Register extends Controller
{
  public $AdminModel;

  public function __construct()
  {
    $this->AdminModel = $this->model("AdminModel");
  }

  public function Default()
  {
    self::layout("sign", [
      "View"  => "create-admin"
    ]);
  }

  public function CreateAdmin()
  {
    // get register form
    if (isset($_POST["submitCreateAdminFormBtn"])) {
      $name = $_POST["name"];
      $username = $_POST["username"];
      $password = $_POST["password"];
      $requestData = [
        "username" =>  $username,
        "pass" =>  $password,
        "name" => $name,
        "status" => 1,
        "notification_yes" => 1,
        "role" => 1
      ];
      //call api Create Admin
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/admin/create.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      //Show result
      self::layout("sign", [
        "View"  => "create-admin",
        "res" => $res
      ]);
    } else {
      self::layout("sign", [
        "View"  => "create-admin"
      ]);
    }
  }
}
