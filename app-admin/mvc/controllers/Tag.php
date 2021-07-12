<?php
class Tag extends Controller
{

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Tag/Read');
  }

  public function Create()
  {
    if (isset($_POST["submitAddTagFormBtn"])) {
      $id_admin = $_POST["id_admin"];
      $tag_description = $_POST["tag_description"];
      $requestData = [
        "mod_id" =>  $id_admin,
        "description" => $tag_description,
        "status" => 1
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/tag/create.php";
      $responseData =   $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        header('Location:' . _WEB_ROOT . '/Tag/Read');
      }
      echo "<h1> them tag khong thanh cong</h1>";
    } else {
      echo "<h1> them tag khong thanh cong vi khong co du lieu</h1>";
    }
  }

  public function Read()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/tag/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "tag",
        "Tags" => $res["tags"],
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
      $id_tag = $_POST["id_tag"];
      $tag_description = $_POST["tag_description"];

      $requestData = [
        "id_tag" =>  $id_tag,
        "description" => trim($tag_description)
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/tag/update.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Tag/Read');
  }

  public function Delete()
  {
    if (isset($_POST["submitDeleteCate"])) {
      $id_tag = $_POST["id_tag"];
      $requestData = [
        "id_tag" =>  $id_tag,
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/tag/delete.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Tag/Read');
  }
}
