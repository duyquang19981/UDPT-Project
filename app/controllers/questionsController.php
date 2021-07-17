<?php

class QuestionsController
{
    public function create()
    {   
        if(
            !empty($_REQUEST["tags"]) &&
            !empty($_REQUEST["link"]) &&
            !empty($_REQUEST["exampleFormControlTextarea1"]) &&
            !empty($_REQUEST["exampleFormControlSelect1"])
        )
        {
            $link = $_REQUEST["link"];
            
            // $datas = {
            //     "category_id" => $_REQUEST["exampleFormControlSelect1"],
            //     "description" => $_REQUEST["exampleFormControlTextarea1"],
            //     "tags" => $_REQUEST["tags"],
            //     "created" => ,
            //     "owner_id" => $_SESSION["user_id"],
            //     "jwt" => $_SESSION["jwt"]
            // }
        }   
        
         
         
          
          
    } 

    

    
}
