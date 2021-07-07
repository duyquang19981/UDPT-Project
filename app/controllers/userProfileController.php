<?php

class userProfileController
{
    public function index($id)
    {   
        require_once "./app/core/callapi.php";
        require_once "./app/config.php";
        $callapi = new callapi();
        try
        {
            $response = $callapi->callAPI('GET', _API_ROOT.'user_account/read_one.php?id_user='.$id, null);
            if($response["code"]>=400)
                {
                    echo $response["data"]["message"];
                
                }else
                {
                    $response1 = $callapi->callAPI('GET', _API_ROOT.'user_account/getNumQues.php?id_user='.$id, null);
                    if($response1["code"]>=400)
                        {
                            echo $response1["data"]["message"];
                        
                        }else
                        {
                            $user = [
                                "id" => $response["data"]["id_user"],
                                "email" => $response["data"]["email"],
                                "name" => $response["data"]["name"],
                                "image" => $response["data"]["image"],
                                "phone" => $response["data"]["phone"],
                                "birth" => $response["data"]["birth"],
                                "created" => $response["data"]["created"],
                                "ques" => $response1["data"]["ques"],
                                "answer" => $response1["data"]["answer"],
                            ];
                            $VIEW = "./app/views/user/userProfile.phtml";
                            require("./app/layouts/questionLayout.phtml");
                        }
                }
            
        }
        catch(Exception $e)
        {
            $VIEW = "./app/views/user/userProfile.phtml";
            require("./app/layouts/questionLayout.phtml");
        };
        
    }
    
}
