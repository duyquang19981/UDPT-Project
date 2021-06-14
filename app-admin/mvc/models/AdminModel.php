<?php
class AdminModel extends Database
{
  public function CreateAdmin($name, $username, $password)
  {
    $query = "INSERT INTO admin VALUES(NULL, '$name','$username','$password', 1,1,1)";

    $result = false;
    if (mysqli_query($this->connect, $query)) {
      $result = true;
    };
    return json_encode($result);
  }
}
