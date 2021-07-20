<?php
class Controller
{
  public static function layout($layout, $data = [])
  {
    require_once "./app/layouts/" . $layout . ".php";
  }
}
