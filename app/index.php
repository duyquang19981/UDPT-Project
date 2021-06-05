<?php
require_once("./controllers/user/HomeController.php");
require_once("./controllers/user/LoginController.php");
require_once("./controllers/user/SignupController.php");
$actiondo = "";
if (isset($_REQUEST["action"]))
{    
    $action = $_REQUEST["action"];
}

switch ($action)
{
    case "login":
        $controller = new LoginController();
        $controller->index();
        break;
    case "signup":
        $controller = new SignupController();
        $controller->index();
        break;
default:
        $controller = new HomeController();
        $controller->index();
        break;
}