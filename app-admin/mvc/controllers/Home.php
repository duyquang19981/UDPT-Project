<?php

class Home extends Controller
{
  public $SinhvienModel;

  public function __construct()
  {
    $this->SinhvienModel = self::model("SinhVienModel");
  }

  public  function Default()
  {
    $data =  [
      "View" => "login",
      "color" => "red",
      "SoThich" => ["a", "b", "c"],
      "SV" => $this->SinhvienModel->SinhVien()
    ];
    self::layout(
      "sign",
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
