<?php

class Home extends Controller
{
  public function index($category_id, $page)
  {
    $categoryModel = $this->modelAPI('category_ques');
    $stmt = $categoryModel->readAll();
    $num = $stmt->rowCount();
    $res =  ["result" => "true", "categories" => []];
    if ($num > 0) {
      // products array
      $category = array();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $category = array(
          "category_id" => $CATEGORY_ID,
          "mod_id" => $MOD_ID,
          "name" => $NAME,
          "status" => $STATUS,
          "created" => $CREATED,
        );

        array_push($res["categories"], $category);
      }

      $res["result"] = "true";
    }
    $categories = $res["categories"];
    print_r($categories);

    return 0;
    //check filter by category or not 
    if (empty($category_id)) {
      $category_id = -1;
    }
    if (!isset($page)) {
      $page = 1;
    }

    //get questions
    // $url =  'https://measking.herokuapp.com/api/data_api/' . "question/read-by-categoryId.php";
    // $responseData =  $callapi->callAPI("POST", $url,  $requestData);
    $res =  ["result" => "true", "questions" => []];

    $questions = [];
    $questionModel = $this->modelAPI('question');
    $questionModel->category_id = $category_id;
    $questionModel->offset = ($page - 1) * $questionModel->limit;

    $stmt = $questionModel->readByCategoryId();
    $num = $stmt->rowCount();
    if ($num > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $ques = array(
          "id_question" => $ID_QUESTION,
          "owner_id" => $OWNER_ID,
          "category_id" => $CATEGORY_ID,
          "mod_id" => $MOD_ID,
          "description" => $DESCRIPTION,
          "likes" => $LIKES,
          "created" => $CREATED,
          "accept_day" => $ACCEPT_DAY,
          "status" => $STATUS,
          "comment" => 0,
          "tags" => []
        );

        $cateModel = $this->modelAPI('category_ques');
        $ques["category_name"] = $cateModel->getNamebyid($ques["category_id"]);

        $tagModel = $this->modelAPI('tag');
        $temp = $tagModel->getbyquesid($ques["id_question"]);
        while ($row = $temp->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $tag = array(
            "DESCRIPTION" => $DESCRIPTION,
          );

          array_push($ques["tags"], $tag);
        }

        $answerModel = $this->modelAPI('answer');
        $answerModel->id_question =  $ques["id_question"];
        $stmt1 =  $answerModel->readByQuesID();
        $ques["comment"] = $stmt1->rowCount();

        array_push($res["questions"], $ques);
      }


      $stmt = $questionModel->countByCategoryId();
      $totalQues = $stmt->fetch(PDO::FETCH_ASSOC);
      $res["totalPages"] = ceil($totalQues["COUNT(*)"] / $questionModel->limit);

      $res["result"] = "true";
    } else {
      $stmt = $question->countByCategoryId();
      $total = $stmt->fetch(PDO::FETCH_ASSOC);
      $res["totalPages"] = $total["COUNT(*)"];
    }

    $totalPages  = $res["totalPages"];
    foreach ($res["questions"] as $question) {
      $id = $question["owner_id"];
      // $response = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_one.php?id_user=' . $id, null);
      // $userModel = new user_account($db);
      $userModel = $this->modelAPI('user_account');
      $userModel->id_user =  $id;
      $userModel->readOne();
      $user_arr = array();
      if ($userModel->name != null) {
        $user_arr = array(
          "id_user" =>  $userModel->id_user,
          "name" => $userModel->name,
          "image" => $userModel->image,
          "email" => $userModel->email,
          "birth" => $userModel->birth,
          "phone" => $userModel->phone,
          "created" => $userModel->created,
        );
      }
      // $responseQuesNum = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/getNumQues.php?id_user=' . $id, null);
      // echo $userModel['id_user'];
      $ques = 0;
      $ans = 0;
      $ques = $userModel->getnumques($id);
      $ans = $userModel->getnumans($id);
      $user_arr["ques"] =  $ques;
      $user_arr["answer"] =  $ans;

      $user = [
        "id" => $user_arr["id_user"],
        "username" => $user_arr["name"],
        "image" => $user_arr["image"],
        "answer" => $user_arr["answer"],
      ];
      $question = array_merge($question, $user);
      array_push($questions, $question);
    }
    print_r($questions);
    return 0;
    // $response2 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/ranking-5-in-month.php', 0);
    $stmt = $userModel->readAll();
    $num = $stmt->rowCount();

    $arr = array();
    if ($num > 0) {
      $users = array();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user = array(
          "id_user" => $ID_USER,
          "name" => $NAME,
          "image" => $IMAGE,
          "email" => $EMAIL,
          "birth" => $BIRTH,
          "phone" => $PHONE,
          "status" => $STATUS,
          "created" => $CREATED,

        );
        $month = date('m');
        $ques = 0;
        $ans = 0;
        $ques = $userModel->getnumquesInMonth($ID_USER, $month);
        $ans = $userModel->getnumansInMonth($ID_USER, $month);
        $user['ques'] =  $ques;
        $user['answer'] =  $ans;
        array_push($users, $user);
      }

      for ($i = 0; $i < count($users) - 1; $i++) {
        $max = $i;
        for ($j = $i + 1; $j < count($users); $j++) {
          if ($users[$max]['answer'] < $users[$j]['answer']) {
            $max = $j;
          }
        }
        $temp  = $users[$i];
        $users[$i] = $users[$max];
        $users[$max] = $temp;
      }


      for ($i = 0; $i < 5; $i++) {
        array_push($arr, $users[$i]);
      }
    }
    $top =  $arr;

    $user_profile = null;
    if (isset($_SESSION["jwt"])) {
      // $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_user_profile.php?id_user=' . $_SESSION["user_id"], 0);
      $userModel->id_user = isset($_GET['id_user']) ? $_GET['id_user'] : die();

      // read the details of product to be edited
      $userModel->readOne();

      if ($userModel->name != null) {
        // create array
        $user_arr = array(
          "name" => $userModel->name,
          "image" => $userModel->image,
          "email" => $userModel->email,
        );

        $user_arr["ques"] = $userModel->getnumques($userModel->id_user);
        $user_arr["answer"] = $userModel->getnumans($userModel->id_user);

        $stmt = $userModel->readAll();
        $num = $stmt->rowCount();
        $users = array();
        if ($num > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $userss = array(
              "id_user" => $ID_USER,
              "name" => $NAME,
              "image" => $IMAGE,
              "email" => $EMAIL,
              "birth" => $BIRTH,
              "phone" => $PHONE,
              "status" => $STATUS,
              "created" => $CREATED,

            );
            $month = date('m');
            $ques = 0;
            $ans = 0;
            $ques = $userModel->getnumquesInMonth($ID_USER, $month);
            $ans = $userModel->getnumansInMonth($ID_USER, $month);
            $userss['ques'] =  $ques;
            $userss['answer'] =  $ans;
            array_push($users, $userss);
          };
          for ($i = 0; $i < count($users) - 1; $i++) {
            $max = $i;
            for ($j = $i + 1; $j < count($users); $j++) {
              if ($users[$max]['answer'] < $users[$j]['answer']) {
                $max = $j;
              }
            }
            $temp  = $users[$i];
            $users[$i] = $users[$max];
            $users[$max] = $temp;
          }

          for ($i = 0; $i < count($users); $i++) {
            if ($users[$i]['id_user'] == $userModel->id_user) {
              $user_arr['top'] =  $i + 1;
            }
          }
        }
      }

      $user_profile =  $user_arr;
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
    $response2 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/ranking-5-in-month.php', 0);
    $top =  $response2["data"]["res"];

    $user_profile = null;
    if (isset($_SESSION["jwt"])) {
      $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_user_profile.php?id_user=' . $_SESSION["user_id"], 0);
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
    if (isset($_SESSION["jwt"])) {
      $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_user_profile.php?id_user=' . $_SESSION["user_id"], 0);
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
    $response2 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/ranking-5-in-month.php', 0);
    $top =  $response2["data"]["res"];

    $user_profile = null;
    if (isset($_SESSION["jwt"])) {
      $response3 = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_user_profile.php?id_user=' . $_SESSION["user_id"], 0);
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
