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
      $result = $this->AdminModel->CreateAdmin($name, $username, $password);
      //Show result
      self::layout("sign", [
        "View"  => "create-admin",
        "result" => $result
      ]);
    }
  }
}
