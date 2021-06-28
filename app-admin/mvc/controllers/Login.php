<?php
class Login extends Controller
{
  public $AdminModel;

  public function __construct()
  {
    $this->AdminModel = $this->model("AdminModel");
  }

  public function Default()
  {
    if (isset($_POST["submitLoginFormBtn"])) {
      $username = $_POST["username"];
      $password = $_POST["password"];
      //call api login Admin
      $requestData = [
        "username" =>  $username,
        "pass" =>  $password
      ];
      $callapi = new callapi();
      $requestData =    json_encode($requestData);
      $url =  _API_ROOT . "/admin/login.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];

      if ($res["result"] != "false") {
        $adminData = $res['data'];
        $_adminID = $adminData["id_admin"];
        $_username = $adminData["username"];
        $_name = $adminData["name"];
        $_notification_yes = $adminData["notification_yes"];

        Session::set('admin-login', true);
        Session::set('admin-id', $_adminID);
        Session::set('admin-username', $_username);
        Session::set('admin-name', $_name);
        Session::set('notification_yes', $_notification_yes);

        // return Home
        header('Location:Home');
      } else {
        self::layout("sign", [
          "View"  => "login",
          "res" => $res,
        ]);
      }
    } else {
      self::layout("sign", [
        "View"  => "login",
      ]);
    }
  }

  public function Logout()
  {
    Session::destroy();
  }
}
