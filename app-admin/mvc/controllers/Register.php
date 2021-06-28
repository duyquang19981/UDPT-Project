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
      $password = password_hash($password, PASSWORD_DEFAULT);
      //call api Create Admin
      $res = $this->AdminModel->CreateAdmin($name, $username, $password);
      $res = json_decode($res, true);
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
