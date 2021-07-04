<?php
class Label extends Controller
{

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Label/Read');
  }

  public function Create()
  {
    if (isset($_POST["submitAddLabelFormBtn"])) {
      $id_admin = $_POST["id_admin"];
      $label_description = $_POST["label_description"];
      $requestData = [
        "mod_id" =>  $id_admin,
        "description" => $label_description,
        "status" => 1
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/label/create.php";
      $responseData =   $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] != "false") {
        header('Location:' . _WEB_ROOT . '/Label/Read');
      }
      echo "<h1> them label khong thanh cong</h1>";
    } else {
      echo "<h1> them label khong thanh cong</h1>";
    }
  }

  public function Read()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/label/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "label",
        "Labels" => $res["labels"],
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
      $id_label = $_POST["id_label"];
      $label_description = $_POST["label_description"];

      $requestData = [
        "id_label" =>  $id_label,
        "description" => trim($label_description)
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/label/update.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Label/Read');
  }

  public function Delete()
  {
    if (isset($_POST["submitDeleteCate"])) {
      $id_label = $_POST["id_label"];
      $requestData = [
        "id_label" =>  $id_label,
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/label/delete.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Label/Read');
  }
}
