<?php
class notification
{

  // database connection and table name
  private $conn;
  private $table_name = "notification";

  // object properties
  public $id_noti;
  public $id_question;
  public $id_answer;
  public $content;
  public $created;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function getById()
  {
    $query = "SELECT * FROM 
                    " . $this->table_name . "
              WHERE id_noti =:id_noti";
    $stmt = $this->conn->prepare($query);
    $this->id_noti = htmlspecialchars(strip_tags($this->id_noti));
    $stmt->bindParam(":id_noti", $this->id_noti, PDO::PARAM_INT);

    if ($stmt->execute()) {
      return $stmt;
    }

    return 0;
  }

  function readAll()
  {
    $query = "SELECT * FROM 
                  " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    if ($stmt->execute()) {
      return $stmt;
    }

    return 0;
  }
}
