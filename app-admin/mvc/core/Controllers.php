<?php
class Controller
{

  public static function model($model)
  {
    require_once "./mvc/models/".$model .".php";
    return new $model;
  }
  public static function layout($layout, $data=[])
  {
    require_once "./mvc/views/layouts/".$layout .".php";
  }

}

