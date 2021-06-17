<?php
class app{
    protected $kind = "user";
    protected $Controller = "home";
    protected $Action = "index";
    protected $Params = [];

    function __construct()
    {
        if ($this->getUrl()!= null)
        {
            $link = $this->getUrl();
            // kiểm tra đường đẫn có tồn tại không
            if (isset($link[0]))
            {
                $this->kind = $link[0];
            }
            if (isset($link[1]))
            {
                $this->Controller = $link[1];
            }
            if (isset($link[2]))
            {
                $this->Action = $link[2];
            }
            // chuyển luồng giữa admin và user
            switch ($this->kind)
            {
                case "admin":
                    echo "admin/";
                    break;
                case "user":
                    echo "user/";
                    switch ($this->Controller)                    
                    {
                        case "signup":
                            echo "signup/";
                            require_once "./app/controllers/user/SignupController.php";
                            $controller = new SignupController();
                            $controller->index();
                            break;
                        case "login":
                            echo "login/";
                            require_once "./app/controllers/user/LoginController.php";
                            $controller = new LoginController();
                            $controller->index();
                            break;
                        default:
                            echo "Home/";
                            require_once "./app/controllers/user/HomeController.php";
                            $controller = new HomeController();
                            $controller->index();
                            break;
                    }
                    break;
            }
        }
        else
        {
            echo "eror";
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