<?php
class Category extends Controller
{

  public function Default()
  {
    // header('Location:' . _WEB_ROOT . '/Category/Read');
    // header('Location:' . _WEB_ROOT . '/Home');

  }

  public function Create()
  {
    echo "<h1> Creat category:</h1>";
    if (isset($_POST["submitAddCategoryFormBtn"])) {
      $id_admin = $_POST["id_admin"];
      $cate_name = $_POST["cate-name"];
      $today = date("Y-m-d");
      $requestData = [
        "mod_id" =>  $id_admin,
        "name" => $cate_name,
        "created" => $today,
        "status" => 1
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/category/create.php";
      $responseData =   $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        echo "<h1> them category thanh cong </h1>";
        // Session::set('notification_yes', 1);
      }
      // header('Location:' . _WEB_ROOT . '/Category/Read');
      // header('Location:' . _WEB_ROOT . '/Home');

    } else {
      echo "<h1> them category khong thanh cong</h1>";

      // header('Location:' . _WEB_ROOT . '/Category/Read');
      // header('Location:' . _WEB_ROOT . '/Home');

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
      if ($res["result"]) {
        Session::set('notification_yes', 0);
      }
      //Show result
      header('Location:' . _WEB_ROOT . '/Home');
    } else {
      header('Location:' . _WEB_ROOT . '/Home');
    }
  }
}
