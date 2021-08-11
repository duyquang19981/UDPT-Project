<?php

class QuestionsController extends Controller
{
    public function index($id)
    {
        require_once "./app/core/callapi.php";
        require_once "./app/config.php";

        $userModel = $this->modelAPI('user_account');
        $answerModel = $this->modelAPI('answer');
        $categoryModel = $this->modelAPI('category_ques');
        $questionModel = $this->modelAPI('question');
        $tagModel = $this->modelAPI('tag');
        $answerModel = $this->modelAPI('answer');
        $temp_id = [
            "id" => $id
        ];
        // $response0 = $callapi->callAPI('POST', _API_ROOT . 'question/getmaxid.php', json_encode($temp_id));
        if ($questionModel->get_maxid_ques($id) == 1) {
            $max = true;
        } else {
            $max = false;
        }

        if ($max == true) {
            $us = [
                "id_check" => $id
            ];

            // $response = $callapi->callAPI('POST', _API_ROOT . 'question/readone.php', json_encode($us));
            // $question =  $response["data"];
            $questionModel->id_question = $id;
            $questionModel->read_one();
            if ($questionModel->owner_id != null) {
                // create array
                $question = array(
                    "id_question" =>  $questionModel->id_question,
                    "owner_id" => $questionModel->owner_id,
                    "category_id" => $questionModel->category_id,
                    "description" => $questionModel->description,
                    "likes" => $questionModel->likes,
                    "status" => $questionModel->status,
                    "created" => $questionModel->created
                );

                $question["category_name"] = $categoryModel->getNamebyid($question["category_id"]);

                $userModel->id_user = $question["owner_id"];
                $userModel->readOne();

                $question["username"] = $userModel->name;
                $question["user_image"] = $userModel->image;
                $question["tags"] = $tagModel->getbyquesid($question["id_question"]);
            }

            // $us1 = [
            //     "ques_id" => $id
            // ];

            // $response1 = $callapi->callAPI('POST', _API_ROOT . 'answer/getByidQues.php', json_encode($us1));
            $answerModel->id_question = $id;
            $answer = $answerModel->readByQuesID();
            if (isset($answer[0])) {
                $question["anser"] = count($answer);
            } else {
                $question["anser"] = 0;
                $answer = null;
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
            // print_r($users_temp);
            // return 0;
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
                "user_profile" => $user_profile,
            ];

            $VIEW = "./app/views/question/question_detail.phtml";
            require("./app/layouts/questionLayout.phtml");
        } else {
            require("./app/views/error/404.php");
        }
    }
}
