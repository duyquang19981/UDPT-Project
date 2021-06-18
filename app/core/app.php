<?php
class app{
    protected $Controller = "Home";
    protected $Action = "index";
    protected $Params = [];

    function __construct()
    {
        if ($this->getUrl()!= null)
        {
            $link = $this->getUrl();
            if (isset($link[0]))
            {
                // kiểm tra file controller có tồn tại ko
                if(file_exists("./app/controllers/".$link[0]."Controller.php"))
                {
                    $this->Controller = $link[0];
                    unset($link[0]);
                }
                
                
            }
            // chuyển luồng giữa admin và user
            
            switch ($this->Controller)                    
            {
                case "signup":
                    require_once "./app/controllers/signupController.php";
                    $controller = new SignupController();
                    switch ($this->Action)
                    {
                        default:
                            $controller->index();
                            break;
                    }
                    break;
                case "login":
                    require_once "./app/controllers/loginController.php";
                    $controller = new LoginController();
                    // kiểm tra đường dẫn có tồn tại?
                    if (isset($link[2]))
                    {
                        // kiểm tra method trong controller có tồn tại không
                        if(method_exists($controller,$link[1]))
                        {
                            $this->Action = $link[1];
                        }
                        unset($link[1]);
                    }
                    $this->Params = $link?array_values($link):[];
                    switch ($this->Action)
                    {
                        case "loginpost":
                            print_r($this->Params);
                            break;
                        default:
                            $controller->index();
                            break;
                    }
                    break;
                default:
                    require_once "./app/controllers/homeController.php";
                    $controller = new HomeController();
                    switch ($this->Action)
                    {
                        default:
                            $controller->index();
                            break;
                    }
                    break;
            }
        }
        else
        {
            require_once "./app/controllers/homeController.php";
            $controller = new HomeController();
            switch ($this->Action)
            {
                default:
                    $controller->index();
                    break;
            }
        }
        

    }
    function getUrl()
    {
        if (isset($_GET["url"]))
        {
            return explode("/",filter_var(trim($_GET["url"],"/")));
        }
        
    }
}
?>