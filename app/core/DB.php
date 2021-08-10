<?php
class Database
{
  private $host = "sql6.freemysqlhosting.net";
  private $db_name = "sql6430149";
  private $username = "sql6430149";
  private $password = "I4UrnEEINS";
  private $port = 3306;
  public $conn;

  // function __construct()
  // {
  //   $this->connect = mysqli_connect($this->servername, $this->username, $this->password);
  //   mysqli_select_db($this->connect,$this->dbname);
  //   mysqli_query($this->connect, "SET NAMES 'utf8'");
  // }

  public function getConnection()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO(
        "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
        $this->username,
        $this->password
      );
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }

    return $this->conn;
  }
}
