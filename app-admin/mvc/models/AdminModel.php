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

  public function LoginAdmin($username, $password)
  {
    $query = "SELECT * FROM admin WHERE username = '$username' LIMIT 1";
    $queryResult = mysqli_query($this->connect, $query);
    $result = false;
    if ($queryResult->num_rows > 0) {
      $admin = mysqli_fetch_assoc($queryResult);
      $_adminID = $admin["ID_ADMIN"];
      $_username = $admin["USERNAME"];
      $_password = $admin["PASS"];
      $_name = $admin["NAME"];
      echo "<hr/>";
      echo $_username;
      echo "<hr/>";
      echo $_password;
      echo "<hr/>";
      echo $_name;
      echo "<hr/>";

      //check password
      if (password_verify($password, $_password)) {
        $result =  $admin;
      }
    }
    return json_encode($result);
  }
}
