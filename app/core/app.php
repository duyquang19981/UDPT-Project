<?php
class app
{
    protected $Controller = "Home";
    protected $Action = "index";
    protected $Params = [];

    function __construct()
    {
        echo " go here app  ";
        if ($this->getUrl() != null) {
            $link = $this->getUrl();
            // xử lý controller
            echo "    :link". $link . "  ..........";
            if (isset($link[0])) {
                // kiểm tra file controller có tồn tại ko
                if (file_exists("./app/controllers/" . $link[0] . "Controller.php")) {
                    $this->Controller = $link[0];
                    unset($link[0]);
                }
                unset($link[0]);
            }
            switch ($this->Controller) {
                    // xử lý đăng kí
                case "signup":
                    require_once "./app/controllers/signupController.php";
                    $controller = new SignupController();
                    // xử lý action
                    if (isset($link[1])) {
                        // kiểm tra method trong controller có tồn tại không
                        if (method_exists($controller, $link[1])) {
                            $this->Action = $link[1];
                        }
                        unset($link[1]);
                    }
                    switch ($this->Action) {
                        case "otppost":
                            $controller->otppost();
                            break;
                        case "otp":
                            $controller->otp();
                            break;
                        case "signuppost":
                            $controller->signuppost();
                            break;
                        default:
                            $controller->index();
                            break;
                    }
                    break;
                    // xử lý đăng nhập
                case "login":
                    require_once "./app/controllers/loginController.php";
                    $controller = new LoginController();
                    // xử lý action
                    if (isset($link[1])) {
                        // kiểm tra method trong controller có tồn tại không
                        if (method_exists($controller, $link[1])) {
                            $this->Action = $link[1];
                        }
                        unset($link[1]);
                    }
                    switch ($this->Action) {
                        case "logout":
                            $controller->logout();
                            break;
                        case "loginpost":
                            $controller->loginpost();
                            break;
                        default:
                            $controller->index();
                            break;
                    }
                    break;
                    // quên mật khẩu
                case "forgotpass":
                    require_once "./app/controllers/forgotpassController.php";
                    $controller = new ForgotpassController();
                    // xử lý action
                    if (isset($link[1])) {
                        // kiểm tra method trong controller có tồn tại không
                        if (method_exists($controller, $link[1])) {
                            $this->Action = $link[1];
                        }
                        unset($link[1]);
                    }
                    switch ($this->Action) {
                        case "changepass":
                            $controller->changepass();
                            break;
                        case "otppost":
                            $controller->otppost();
                            break;
                        case "fogotpasspost":
                            $controller->fogotpasspost();
                            break;
                        default:
                            $controller->index();
                            break;
                    }
                    break;
                    // user profile
                case "userProfile":
                    require_once "./app/controllers/userProfileController.php";
                    $controller = new userProfileController();
                    // xử lý action
                    if (isset($link[1])) {
                        // kiểm tra method trong controller có tồn tại không
                        if (method_exists($controller, $link[1])) {
                            $this->Action = $link[1];
                        }
                    }
                    switch ($this->Action) {
                        case 'changepass':
                            $controller->changepass();
                            break;
                        default:
                            $id = $link[1];
                            $controller->index($id);
                            break;
                    }
                    break;
                case 'questions':
                    require_once "./app/controllers/questionsController.php";
                    $controller = new QuestionsController();
                    // xử lý action
                    if (isset($link[1])) {
                        // kiểm tra method trong controller có tồn tại không
                        if (method_exists($controller, $link[1])) {
                            $this->Action = $link[1];
                        }
                        switch ($this->Action) {

                            default:
                                $id = $link[1];
                                $controller->index($id);
                                break;
                        }
                    }

                    break;

                default:
                    require_once "./app/controllers/" . $this->Controller . ".php";
                    $this->Controller = new $this->Controller;
                    if (isset($link[1])) {
                        if (method_exists($this->Controller, $link[1])) {
                            $this->Action = $link[1];
                        }
                        unset($link[1]);
                    }
                    $this->Params = $link  ? array_values($link) : [-1, 1];
                    call_user_func_array([$this->Controller, $this->Action], $this->Params);
                    break;
            }
        } else
        //Home
        {
            require_once "./app/controllers/Home.php";
            $Controller = new Home();
            switch ($this->Action) {
                default:
                    $Controller->index(-1, 1);
                    break;
            }
        }
    }
    function getUrl()
    {
        if (isset($_GET["url"])) {
            echo  " 1: " . explode("/", filter_var(trim($_GET["url"], "/"))) .":  ";
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
        else{ echo " cant get url :";}

    }
}
