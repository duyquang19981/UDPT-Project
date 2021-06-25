<?php
class Database
{
  public  $connect;
  protected $servername = "localhost";
  protected $username = "root";
  protected $password  = "";
  protected $dbname = "questiondb";

  function __construct()
  {
    $this->connect = mysqli_connect($this->servername, $this->username, $this->password);
    mysqli_select_db($this->connect,$this->dbname);
    mysqli_query($this->connect, "SET NAMES 'utf8'");
  }
}
