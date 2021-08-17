<?php
class Database
{
  // private $host = "sql6.freemysqlhosting.net";
  // private $db_name = "sql6430149";
  // private $username = "sql6430149";
  // private $password = "I4UrnEEINS";
  // private $port = 3306;
  // public $conn;

  private $host = "remotemysql.com";
  private $db_name = "jPvMGwV89i";
  private $username = "jPvMGwV89i";
  private $password = "nstTU3GyJb";
  private $port = 3306;
  public $conn;

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
