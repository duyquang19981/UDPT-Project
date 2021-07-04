<?php
class Question extends Controller
{

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/Question/Read');
  }


  public function Read()
  {
    $requestData = null;
    $callapi = new callapi();
    $requestData = json_encode($requestData);
    $url =  _API_ROOT . "/question/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "question",
        "FilterTitle" => "Tất cả",
        "Questions" => $res["questions"],
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
    $url =  _API_ROOT . "/question/read-accept-yes.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "question",
        "FilterTitle" => "Đã duyệt",
        "Questions" => $res["questions"],
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
    $url =  _API_ROOT . "/question/read-accept-no.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "question",
        "FilterTitle" => "Chưa duyệt",
        "Questions" => $res["questions"],
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
    $url =  _API_ROOT . "/question/read-deleted.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    if ($res["result"] != "false") {
      $data =  [
        "View" => "question",
        "FilterTitle" => "Đã xóa",
        "Questions" => $res["questions"],
      ];
      self::layout(
        "main",
        $data
      );
    }
  }

  public function Accept()
  {
    if (isset($_POST["submitAcceptQuestion"])) {
      $id_question = $_POST["id_question"];
      $mod_id = $_POST["mod_id"];
      $today = date("Y-m-d");

      $requestData = [
        "id_question" =>  $id_question,
        "mod_id" => trim($mod_id),
        "accept_day" => $today
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/question/accept.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Question/Read');
  }

  public function Delete()
  {
    if (isset($_POST["submitDeleteQuestion"])) {
      $id_question = $_POST["id_question"];
      $requestData = [
        "id_question" =>  $id_question,
      ];
      $callapi = new callapi();
      $requestData = json_encode($requestData);
      $url =  _API_ROOT . "/question/delete.php";
      $responseData =  $callapi->callAPI("POST", $url, $requestData);
      $responseData = $responseData["data"];
      $res = $responseData["res"];
      if ($res["result"] == "false") {
        echo "alert('Khong thanh cong')";
      }
    }
    header('Location:' . _WEB_ROOT . '/Question/Read');
  }
}
