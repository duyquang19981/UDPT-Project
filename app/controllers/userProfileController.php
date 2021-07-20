<?php

class userProfileController
{
    public function index($id)
    {   
        
        require_once "./app/core/callapi.php";
        require_once "./app/config.php";
        $callapi = new callapi();

        $temp_id = [
            "id"=>$id
        ];
        $response0 = $callapi->callAPI('POST', _API_ROOT.'user_account/getmaxid.php', json_encode($temp_id));
        
        if($response0["data"]["max"] == true)
        {
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

                                $response2 = $callapi->callAPI('GET', _API_ROOT.'category/read-all.php', null);
                                $category = $response2["data"]["res"]["categories"];
                                
                                $dataa = [
                                    "owner_id" => $user["id"]
                                ];
                                $response3 = $callapi->callAPI('POST', _API_ROOT.'question/get_by_owner_id.php', json_encode($dataa));
                                if(isset($response3["data"]["res"]))
                                {
                                    $question = $response3["data"]["res"];
                                }
                                else
                                {
                                    $question = null; 
                                }

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
        else
        {
            
            require("./app/views/error/404.php");
        }

        
        
    }
    
}
