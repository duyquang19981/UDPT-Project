<?php
class Login extends Controller
{
  public $AdminModel;

  public function __construct()
  {
    $this->AdminModel = $this->model("AdminModel");
  }

  // This controller will call this function as default action
  public function Default()
  {
    if (isset($_POST["submitLoginFormBtn"])) {
      $username = $_POST["username"];
      $password = $_POST["password"];

      //call api login Admin
      $result = $this->AdminModel->LoginAdmin($username, $password);
      echo "<pre>";
      var_dump($result);
      echo "</pre>";
      $result = json_decode($result, true);
      $_adminID = $result["ID_ADMIN"];
      $_username = $result["USERNAME"];
      $_password = $result["PASS"];
      $_name = $result["NAME"];
      echo "<hr/>";
      echo $_username;
      echo "<hr/>";
      echo $_password;
      echo "<hr/>";
      echo $_name;
      echo "<hr/>";
      if ($result == "true") {
        // đã lấy giữ liệu được từ api, decode ra array, truy cập dữ liệu bình thường
        // Session::set('admin-login', true);
      }
      //Show result

      self::layout("sign", [
        "View"  => "login",
        "result" => $result
      ]);
    } else {
      self::layout("sign", [
        "View"  => "login",
      ]);
    }
  }
}
