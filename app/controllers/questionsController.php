<?php

class QuestionsController
{
    public function index($id)
    { 

        require_once "./app/core/callapi.php";
        require_once "./app/config.php";
        $callapi = new callapi();

        $temp_id = [
            "id"=>$id
        ];
        $response0 = $callapi->callAPI('POST', _API_ROOT.'question/getmaxid.php', json_encode($temp_id));
        
        if($response0["data"]["max"] == true)
        {
            $us = [
                "id_check" => $id
            ];
    
            $response = $callapi->callAPI('POST', _API_ROOT.'question/readone.php', json_encode($us));
            $question =  $response["data"];
            
            $us1 = [
                "ques_id" => $id
            ];
    
            $response1 = $callapi->callAPI('POST', _API_ROOT.'answer/getByidQues.php', json_encode($us1));
            $answer =  $response1["data"];
    
            if(isset($response1["data"][0]))
            {
                $question["anser"] = count($answer);
            }
            else
            {
                $question["anser"] = 0;
                $answer = null;
            }
            
            $VIEW = "./app/views/question/question_detail.phtml";
            require("./app/layouts/questionLayout.phtml");
        }
        else
        {
            
            require("./app/views/error/404.php");
        }
        
        

        
    }
    
    

    
}
