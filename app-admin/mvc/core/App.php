<?php
class App
{
  protected $controller = "Home";
  protected $action = "Default";
  protected $params = [];

  // http://localhost:8080/UDPT/app-admin/Home/SayHi/1/2/3
  function __construct()
  {
    $arr = $this->urlProcess();
    if(empty($arr)){
      $arr[0]= "Home";
    }

    //controller 
    if (file_exists("./mvc/controllers/" . $arr[0] . ".php")) {
      $this->controller = $arr[0];
      unset($arr[0]);
    }
    require_once "./mvc/controllers/" . $this->controller . ".php";
    $this->controller = new $this->controller;

    //action
    if (isset($arr[1])) {
      if (method_exists($this->controller, $arr[1])) {
        $this->action = $arr[1];
      }
      unset($arr[1]);
    }

    //params
    $this->params = $arr ? array_values($arr) : [];
    call_user_func_array([$this->controller, $this->action], $this->params);
  }

  function urlProcess()
  {
    if (isset($_GET["url"])) {
      return explode("/", filter_var(trim($_GET["url"], "/")));
    }
  }
}
