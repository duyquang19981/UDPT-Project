<?php
class API_Sinhvien extends Controller
{
  public function DanhSach()
  {

    $sinhvien = $this->model("SinhvienModel");
    $sv = $sinhvien->SinhVien();
    $mang = [];

    while($s = mysqli_fetch_array($sv)){
      array_push($mang, new SinhVien(
      $s["ID"], 
      $s["HOTEN"], 
      $s["NAMSINH"]
    ));
    }

    echo json_encode($mang);
  }

}


class SinhVien
{
  public $ID;
  public $HOTEN;
  public $NAMSINH;

  public function __construct($id, $hoten, $namsinh)
  {
    $this->ID = $id;
    $this->HOTEN = $hoten;
    $this->NAMSINH = $namsinh;
  }
}
