<?php

class Home extends Controller
{
  public function index($category_id, $page)
  {
    $categoryModel = $this->modelAPI('category_ques');
    $questionModel = $this->modelAPI('question');
    $tagModel = $this->modelAPI('tag');
    $answerModel = $this->modelAPI('answer');
    $userModel = $this->modelAPI('user_account');

    $categories = $categoryModel->readAll();
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

    $questionModel->category_id = $category_id;
    $questionModel->offset = ($page - 1) * $questionModel->limit;

    $questions_temp = $questionModel->readByCategoryId();
    $questions = [];
    $num = count($questions_temp);
    $totalPages  = 1;

    if ($num > 0) {
      foreach ($questions_temp as $ques) {
        $ques["tags"] = $tagModel->getbyquesid($ques["id_question"]);
        $answerModel->id_question =  $ques["id_question"];
        $stmt1 = $answerModel->readByQuesID();
        $ques["comment"] = count($stmt1);

        array_push($questions, $ques);
      }

      $stmt = $questionModel->countByCategoryId();
      $totalQues = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalPages  = ceil($totalQues["COUNT(*)"] / $questionModel->limit);
    } else {
      $stmt = $questionModel->countByCategoryId();
      $total = $stmt->fetch(PDO::FETCH_ASSOC);
      $totalPages  = $total["COUNT(*)"];
    }
    $questions_temp = $questions;
    $questions = [];
    foreach ($questions_temp as $question) {
      $id = $question["owner_id"];
      // $response = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/read_one.php?id_user=' . $id, null);
      // $userModel = new user_account($db);

      // $responseQuesNum = $callapi->callAPI('GET', 'https://measking.herokuapp.com/api/data_api/' . 'user_account/getNumQues.php?id_user=' . $id, null);
      // echo $userModel['id_user'];
      $ques = 0;
      $ans = 0;
      $ques = $userModel->getnumques($id);
      $ans = $userModel->getnumans($id);
      $user_arr["ques"] =  $ques;
      $user_arr["answer"] =  $ans;

      $user = [
        "answer" => $user_arr["answer"],
      ];
      $question = array_merge($question, $user);
      array_push($questions, $question);
    }

    $users_temp = $userModel->readAll();
    $users = $users_temp;
    $num = count($users);
    $arr = array();
    if ($num > 0) {
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
      $userModel->id_user =  $_SESSION["user_id"];

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

        $stmt = $users_temp;
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
    $categoryModel = $this->modelAPI('category_ques');
    $categories = $categoryModel->readAll();
    $questionModel = $this->modelAPI('question');
    $tagModel = $this->modelAPI('tag');
    $answerModel = $this->modelAPI('answer');
    $userModel = $this->modelAPI('user_account');

    //get questions
    $allQuestions = $questionModel->readAcceptedAndNotDeleted();
    $num = count($allQuestions);

    //filter
    $questionsFilter = [];
    $format  = new Format();
    $convertKeyword = trim(strtolower($format->stripVN($keyword)));
    foreach ($allQuestions as $question) {
      if (str_contains(strtolower($format->stripVN($question['description'])), $convertKeyword)) {
        array_push($questionsFilter, $question);
      }
    }

    //get all information
    $tempQuesFilter = [];
    foreach ($questionsFilter as $ques) {
      $ques["tags"] = $tagModel->getbyquesid($ques["id_question"]);
      $answerModel->id_question =  $ques["id_question"];
      $stmt1 = $answerModel->readByQuesID();
      $ques["comment"] = count($stmt1);

      array_push($tempQuesFilter, $ques);
    }

    $questions = [];
    foreach ($tempQuesFilter as $question) {
      $id = $question["owner_id"];
      $ques = 0;
      $ans = 0;
      $ques = $userModel->getnumques($id);
      $ans = $userModel->getnumans($id);
      $user_arr["ques"] =  $ques;
      $user_arr["answer"] =  $ans;

      $user = [
        "answer" => $user_arr["answer"],
      ];
      $question = array_merge($question, $user);
      array_push($questions, $question);
    }
    $users_temp = $userModel->readAll();
    $users = $users_temp;
    $num = count($users);
    // print_r($users_temp);
    // return 0;
    $arr = array();
    if ($num > 0) {
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
      $userModel->id_user =  $_SESSION["user_id"];
      // read the details of product to be edited
      $userModel->readOne();

      if ($userModel->name != null) {
        // create array
        $user_arr = array(
          "name" => $userModel->name,
          "image" => $userModel->image,
          "email" => $userModel->email,
        );
      }
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
    $categoryModel = $this->modelAPI('category_ques');
    $questionModel = $this->modelAPI('question');
    $tagModel = $this->modelAPI('tag');
    $answerModel = $this->modelAPI('answer');
    $userModel = $this->modelAPI('user_account');

    $categories = $categoryModel->readAll();
    $users_temp = $userModel->readAll();
    $users = $users_temp;
    $num = count($users);
    $arr = array();
    if ($num > 0) {
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

      for ($i = 0; $i < 10; $i++) {
        array_push($arr, $users[$i]);
      }
    }

    $user_profile = null;
    if (isset($_SESSION["jwt"])) {
      $userModel->id_user =  $_SESSION["user_id"];
      // read the details of product to be edited
      $userModel->readOne();
    }

    $data =  [
      "View" => "ranking",
      "Categories" => $categories,
      "Users" => $arr,
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
    $categoryModel = $this->modelAPI('category_ques');
    $questionModel = $this->modelAPI('question');
    $tagModel = $this->modelAPI('tag');
    $answerModel = $this->modelAPI('answer');
    $userModel = $this->modelAPI('user_account');

    $tagname = array("DESCRIPTION" => $tagname);

    $categories = $categoryModel->readAll();

    //get questions
    $allQuestions = $questionModel->readAcceptedAndNotDeleted();
    //get tags
    $questionsFilter = [];
    foreach ($allQuestions as $ques) {
      $ques["tags"] = $tagModel->getbyquesid($ques["id_question"]);
      if (in_array($tagname, $ques["tags"])) {
        $answerModel->id_question =  $ques["id_question"];
        $stmt1 = $answerModel->readByQuesID();
        $ques["comment"] = count($stmt1);
        array_push($questionsFilter, $ques);
      }
    }

    //get all information

    $questions = [];
    foreach ($questionsFilter as $question) {
      $id = $question["owner_id"];
      $ques = 0;
      $ans = 0;
      $ques = $userModel->getnumques($id);
      $ans = $userModel->getnumans($id);
      $user_arr["ques"] =  $ques;
      $user_arr["answer"] =  $ans;

      $user = [
        "answer" => $user_arr["answer"],
      ];
      $question = array_merge($question, $user);
      array_push($questions, $question);
    }
    $users_temp = $userModel->readAll();
    $users = $users_temp;
    $num = count($users);
    $arr = array();
    if ($num > 0) {
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
      $userModel->id_user =  $_SESSION["user_id"];
      // read the details of product to be edited
      $userModel->readOne();

      if ($userModel->name != null) {
        // create array
        $user_arr = array(
          "name" => $userModel->name,
          "image" => $userModel->image,
          "email" => $userModel->email,
        );
      }
    }

    $data =  [
      "View" => "home",
      "Categories" => $categories,
      "Questions" => $questions,
      "Page" => $page,
      "cateActive" => -1,
      "tagname" => $tagname["DESCRIPTION"],
      "Top" => $top,
      "user_profile" => $user_profile,
    ];
    self::layout(
      "main",
      $data
    );
  }
}
