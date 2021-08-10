<?php
class Controller
{
  public static function layout($layout, $data = [])
  {
    require_once "./app/layouts/" . $layout . ".php";
  }
  public static function modelAPI($model)
  {
    $database = new Database();
    $db = $database->getConnection();
    require_once "./api/objects/".$model .".php";
    return new $model($db);
  }
}
