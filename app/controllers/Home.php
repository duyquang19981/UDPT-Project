<?php

class Home extends Controller
{
  public function index($category_id, $page)
  {
    $callapi = new callapi();

    //get category
    $url =  'https://measking.herokuapp.com/api/data_api/' . "category/read-all.php";
    echo $url;
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    $categories = $res["categories"];

    //check filter by category or not
    if (empty($category_id)) {
      $category_id = -1;
    }
    if (!isset($page)) {
      $page = 1;
    }
    $requestData = [
      "category_id" =>  $category_id,
      "page" => $page,
    ];
    $requestData = json_encode($requestData);

    //get questions
    $url =  'https://measking.herokuapp.com/api/data_api/' . "question/read-by-categoryId.php";
    $responseData =  $callapi->callAPI("POST", $url,  $requestData);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    $questions = [];
    $totalPages  = $res["totalPages"];
    foreach ($res["questions"] as $question) {
      $id = $question["owner_id"];
      $response = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_one.php?id_user=' . $id, null);
      if ($response["code"] >= 400) {
        echo $response["data"]["message"];
      } else {
        $responseQuesNum = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/getNumQues.php?id_user=' . $id, null);
        if ($responseQuesNum["code"] >= 400) {
          echo $responseQuesNum["data"]["message"];
        } else {
          $user = [
            "id" => $response["data"]["id_user"],
            "username" => $response["data"]["name"],
            "image" => $response["data"]["image"],
            "answer" => $responseQuesNum["data"]["answer"],
          ];
          $question = array_merge($question, $user);
          array_push($questions, $question);
        }
      }
    }
    $response2 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/'.'user_account/ranking-5-in-month.php', 0);
    $top =  $response2["data"]["res"];
    
    $user_profile = null;
    if(isset($_SESSION["jwt"]))
    {
      $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/'.'user_account/read_user_profile.php?id_user='.$_SESSION["user_id"], 0);
      $user_profile =  $response3["data"];  
    }
    

    $data =  [
      "View" => "home",
      "Categories" => $categories,
      "Questions" => $questions,
      "Page" => $page,
      "TotalPages" => $totalPages,
      "cateActive" => $category_id,
      "Top" => $top,
      "user_profile" => $user_profile,
    ];
    self::layout(
      "main",
      $data
    );
  }

  public function Search($keyword, $page)
  {
    if (isset($_POST["submitSearch"])) {
      $keyword = $_POST["keyword"];
    }
    if (empty(trim($keyword))) {
      header('Location:' . _WEB_ROOT . '/Home');
      return;
    }
    $callapi = new callapi();
    //get category
    $url =  'https://measking.herokuapp.com/api/data_api/' . "category/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    $categories = $res["categories"];
    //get questions
    $url =  'https://measking.herokuapp.com/api/data_api/' . "question/read-accepted-and-not-deleted.php";
    $responseData =  $callapi->callAPI("POST", $url,  0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    //filter
    $questionsFilter = [];
    $format  = new Format();
    $convertKeyword = trim(strtolower($format->stripVN($keyword)));
    foreach ($res["questions"] as $question) {
      if (str_contains(strtolower($format->stripVN($question['description'])), $convertKeyword)) {
        array_push($questionsFilter, $question);
      }
    }
    //get all information
    $questions = [];
    foreach ($questionsFilter as $question) {
      $id = $question["owner_id"];
      $response = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_one.php?id_user=' . $id, null);
      if ($response["code"] >= 400) {
        echo $response["data"]["message"];
      } else {
        $responseQuesNum = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/getNumQues.php?id_user=' . $id, null);
        if ($responseQuesNum["code"] >= 400) {
          echo $responseQuesNum["data"]["message"];
        } else {
          $user = [
            "id" => $response["data"]["id_user"],
            "username" => $response["data"]["name"],
            "image" => $response["data"]["image"],
            "answer" => $responseQuesNum["data"]["answer"],
          ];
          $question = array_merge($question, $user);
          array_push($questions, $question);
        }
      }
    }
    $response2 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/'.'user_account/ranking-5-in-month.php', 0);
    $top =  $response2["data"]["res"];

    $user_profile = null;
    if(isset($_SESSION["jwt"]))
    {
      $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/'.'user_account/read_user_profile.php?id_user='.$_SESSION["user_id"], 0);
      $user_profile =  $response3["data"];  
    }

    $data =  [
      "View" => "home",
      "Categories" => $categories,
      "Questions" => $questions,
      "Page" => $page,
      "cateActive" => -1,
      "Keyword" => $keyword,
      "Top" => $top,
      "user_profile" => $user_profile,
    ];
    self::layout(
      "main",
      $data
    );
  }

  public function Ranking($none1, $none2)
  {
    $callapi = new callapi();

    //get category
    $url =  'https://measking.herokuapp.com/api/data_api/' . "category/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    $categories = $res["categories"];


    $url =  'https://measking.herokuapp.com/api/data_api/' . "user_account/ranking-in-month.php";
    $responseData =  $callapi->callAPI("GET", $url,  0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    $users = $res["user_accounts"];

    $user_profile = null;
    if(isset($_SESSION["jwt"]))
    {
      $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/'.'user_account/read_user_profile.php?id_user='.$_SESSION["user_id"], 0);
      $user_profile =  $response3["data"];  
    }

    $data =  [
      "View" => "ranking",
      "Categories" => $categories,
      "Users" => $users,
      "user_profile" => $user_profile,
    ];
    self::layout(
      "main",
      $data
    );
  }

  public function SearchByTag($tagname, $page)
  {
    if (isset($_POST["submitSearchTagName"])) {
      $tagname = $_POST["tagname"];
    }
    if (empty(trim($tagname))) {
      header('Location:' . _WEB_ROOT . '/Home');
      return;
    }
    $callapi = new callapi();
    //get category
    $url =  'https://measking.herokuapp.com/api/data_api/' . "category/read-all.php";
    $responseData =  $callapi->callAPI("GET", $url, 0);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    $categories = $res["categories"];
    //get questions
    $requestData = [
      "tagname" =>  $tagname
    ];

    $requestData = json_encode($requestData);
    $url =  'https://measking.herokuapp.com/api/data_api/' . "question/read-by-tagname.php";
    $responseData =  $callapi->callAPI("POST", $url,  $requestData);
    $responseData = $responseData["data"];
    $res = $responseData["res"];

    //get all information
    $questionsFilter = $res["questions"];
    $questions = [];
    foreach ($questionsFilter as $question) {
      $id = $question["owner_id"];
      $response = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_one.php?id_user=' . $id, null);
      if ($response["code"] >= 400) {
        echo $response["data"]["message"];
      } else {
        $responseQuesNum = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/getNumQues.php?id_user=' . $id, null);
        if ($responseQuesNum["code"] >= 400) {
          echo $responseQuesNum["data"]["message"];
        } else {
          $user = [
            "id" => $response["data"]["id_user"],
            "username" => $response["data"]["name"],
            "image" => $response["data"]["image"],
            "answer" => $responseQuesNum["data"]["answer"],
          ];
          $question = array_merge($question, $user);
          array_push($questions, $question);
        }
      }
    }
    $response2 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/'.'user_account/ranking-5-in-month.php', 0);
    $top =  $response2["data"]["res"];

    $user_profile = null;
    if(isset($_SESSION["jwt"]))
    {
      $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/'.'user_account/read_user_profile.php?id_user='.$_SESSION["user_id"], 0);
      $user_profile =  $response3["data"];  
    }

    $data =  [
      "View" => "home",
      "Categories" => $categories,
      "Questions" => $questions,
      "Page" => $page,
      "cateActive" => -1,
      "tagname" => $tagname,
      "Top" => $top,
      "user_profile" => $user_profile,
    ];
    self::layout(
      "main",
      $data
    );
  }
}
