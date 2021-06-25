<?php
class SinhVienModel extends Database  
{
  public  function GetSV()
  {
    //connect db
    return "Duy qung";
  }

  public  function Tong($n, $m)
  {
    return $n + $m;
  }
  public  function SinhVien()
  {
    $sql = "SELECT * FROM sinhvien";
    return mysqli_query($this->connect,$sql);
  }
}
