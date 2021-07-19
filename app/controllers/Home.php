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
    if (isset($page)) {
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
    $questions = $res["questions"];
    $totalPages  = $res["total"];
    print_r($questions);
    echo $totalPages;
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
