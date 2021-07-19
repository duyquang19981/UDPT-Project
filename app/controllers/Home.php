<?php

class Home extends Controller
{
  public  function index($category_id, $page)
  {
    $callapi = new callapi();

    //get category
    $url =  _API_ROOT . "/category/read-all.php";
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
    $url =  _API_ROOT . "/question/read-by-categoryId.php";
    $responseData =  $callapi->callAPI("POST", $url,  $requestData);
    $responseData = $responseData["data"];
    $res = $responseData["res"];
    $questions = [];
    $totalPages  = $res["totalPages"];
    foreach ($res["questions"] as $question) {
      $id = $question["owner_id"];
      $response = $callapi->callAPI('GET', _API_ROOT . 'user_account/read_one.php?id_user=' . $id, null);
      if ($response["code"] >= 400) {
        echo $response["data"]["message"];
      } else {
        $responseQuesNum = $callapi->callAPI('GET', _API_ROOT . 'user_account/getNumQues.php?id_user=' . $id, null);
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
    $data =  [
      "View" => "home",
      "Categories" => $categories,
      "Questions" => $questions,
      "Page" => $page,
      "TotalPages" => $totalPages,
      "cateActive" => $category_id,
    ];
    self::layout(
      "main",
      $data
    );
  }
}
