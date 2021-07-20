<?php
class User_account extends Controller
{

  public function Default()
  {
    header('Location:' . _WEB_ROOT . '/user_account/Read/1');
  }

  public function Read($page)
  {
    if($page <0)
    {
        $page = 1;
    }
    $requestData = null;
    $callapi = new callapi();
    $url =  _API_ROOT . "/user_account/read_paging.php?page=".$page;
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData;
    if ($res!= "false" && isset($res["data"])) {
      $data =  [
        "View" => "user_account",
        "User" => $res["data"],
        "paging" => $res["paging"],
      ];
      self::layout(
        "main",
        $data
      );
    }
    else
      {
        $data =  [
          "View" => "user_account"
        ];
        self::layout(
          "main",
          $data
        );
      }
  }

  public function updateStatus()
  {
    if (isset($_POST["changestatus"])) {
      $id_user = $_POST["user_input_id"];
      $status = $_POST["status"];

      if($status == 1)
      {
        $status = 0;
      }
      else
      {
        $status =1;
      }
      $data = [
        "status" => $status,
        "id_user" => $id_user
      ];
      $callapi = new callapi();
      $requestData = json_encode($data);
      $url =  _API_ROOT . "/user_account/updateStatus.php";
      $responseData =   $callapi->callAPI("POST", $url, $requestData);
      if($responseData["code"]>=400)
      {
        $url =  _API_ROOT . "/user_account/read_paging.php?page=".$page;
        $responseData1 =  $callapi->callAPI("GET", $url, 0);
        $responseData1 = $responseData1["data"];
        $res = $responseData1;
        if ($res!= "false") {
          $data =  [
            "View" => "user_account",
            "User" => $res["data"],
            "paging" => $res["paging"],
            "messenger" => $responseData["data"]["message"]
          ];
          self::layout(
            "main",
            $data
          );
        }
      }
      else
      {
        header('Location:' . _WEB_ROOT . '/user_account/Read/1');
      }

    }
  }

  public function Search($keyword,$page)
  {
    if ($keyword == "")
    {
      header('Location:' . _WEB_ROOT . '/user_account/Read/1');
    }
    else {
      $callapi = new callapi();
      $data = [
        "name" => $keyword,
        "page" => $page
      ];
      $url =  _API_ROOT . "/user_account/search.php";
      $responseData =  $callapi->callAPI("POST", $url, json_encode($data));
      $responseData = $responseData["data"];
      $res = $responseData;
      if ($res!= "false" && isset($res["data"])) 
      {
        $data =  [
          "View" => "user_account",
          "User" => $res["data"],
          "paging" => $res["paging"],
          "keyword" => $keyword,
        ];
        self::layout(
          "main",
          $data
        );
      }
      else
      {
        $data =  [
          "View" => "user_account"
        ];
        self::layout(
          "main",
          $data
        );
      }
    }
  }

}