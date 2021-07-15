<?php
class rating
{

  // database connection and table name
  private $conn;
  private $table_name = "rating";

  // object properties
  public $id_rating;
  public $owner_id;
  public $question_id;
  public $answer_id;
  public $star;
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
