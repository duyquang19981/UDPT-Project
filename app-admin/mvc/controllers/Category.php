<?php
class Category extends Controller
{

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Category/Read');
  }

  public function Create()
  {
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
        header('Location:' . _WEB_ROOT . '/Category/Read');
      }
      echo "<h1> them category khong thanh cong</h1>";
    } else {
      echo "<h1> them category khong thanh cong</h1>";
    }
  }

  public function Read()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/category/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "category",
        "Categories" => $res["categories"],
      ];
      self::layout(
        "main",
        $data
      );
    }
  }

  public function Update()
  {
    if (isset($_POST["submitUpdateCate"])) {
      $cate_id = $_POST["cate_id"];
      $cate_name = $_POST["cate_name"];

      $requestData = [
        "category_id" =>  $cate_id,
        "name" => trim($cate_name)
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/category/update.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Category/Read');
  }

  public function Delete()
  {
    if (isset($_POST["submitDeleteCate"])) {
      $cate_id = $_POST["cate_id"];
      $requestData = [
        "category_id" =>  $cate_id,
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/category/delete.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Category/Read');
  }
}
