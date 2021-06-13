<?php

class Home extends Controller
{
  // public 
  public function __construct()
  {
    self::Default();
  }

  static function Default()
  {
    $teo = self::model("SinhVienModel");
    $data =  [
      "View" => "news",
      "color" => "red",
      "SoThich" => ["a", "b", "c"],
      "SV" => $teo->SinhVien()
    ];
    self::layout(
      "main",
      $data
    );
  }

  static function Show($a, $b)
  {
    $teo = self::model("SinhVienModel");
    $tong = $teo->Tong($a, $b);
    self::layout(
      "main",
      [
        "Page" => "news",
        "Number" => $tong,
        "color" => "red",
        "SoThich" => ["a", "b", "c"],
        "SV" => $teo->SinhVien()
      ]
    );    //require apdep.php
  }
}
