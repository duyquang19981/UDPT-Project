<?php
class Answer extends Controller
{

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Answer/Read');
  }


  public function Read()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/answer/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "answer",
        "FilterTitle" => "Tất cả",
        "Answers" => $res["answers"],
      ];
      self::layout(
        "main",
        $data
      );
    }
  }

  public function ReadAcceptYes()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/answer/read-accept-yes.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "answer",
        "FilterTitle" => "Đã duyệt",
        "Answers" => $res["answers"],
      ];
      self::layout(
        "main",
        $data
      );
    }
  }

  public function ReadAcceptNo()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/answer/read-accept-no.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "answer",
        "FilterTitle" => "Chưa duyệt",
        "Answers" => $res["answers"],
      ];
      self::layout(
        "main",
        $data
      );
    }
  }

  public function ReadDeleted()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/answer/read-deleted.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "answer",
        "FilterTitle" => "Đã xóa",
        "Answers" => $res["answers"],
      ];
      self::layout(
        "main",
        $data
      );
    }
  }

  public function Accept()
  {
    if (isset($_POST["submitAcceptAnswer"])) {
      $id_answer = $_POST["id_answer"];
      $mod_id = $_POST["mod_id"];
      $today = date("Y-m-d");

      $requestData = [
        "id_answer" =>  $id_answer,
        "mod_id" => trim($mod_id),
        "accept_day" => $today
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/answer/accept.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Answer/Read');
  }

  public function Delete()
  {
    if (isset($_POST["submitDeleteAnswer"])) {
      $id_answer = $_POST["id_answer"];
      $requestData = [
        "id_answer" =>  $id_answer,
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/answer/delete.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Answer/Read');
  }
}
