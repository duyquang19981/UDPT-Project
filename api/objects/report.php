<?php
class report
{

  // database connection and table name
  private $conn;
  private $table_name = "report";

  // object properties
  public $id_report;
  public $id_owner;
  public $id_question;
  public $reason;
  public $created;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
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
