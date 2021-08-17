<?php
class Database
{
  
  private $host = "38.17.53.116";
  private $db_name = "question";
  private $username = "admin";
  private $password = "asdsddsa";
  private $port = 19871;
  public $conn;


  public function getConnection()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO(
        "mysql:host=" . $this->host . ";port=" . $this->port .
          ";dbname=" . $this->db_name,
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
