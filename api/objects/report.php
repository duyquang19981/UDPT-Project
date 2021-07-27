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

  function create()
  {
    $query = "INSERT INTO
                  " . $this->table_name . "
              VALUES(
              NULL, :id_owner, :id_question, :reason, :created )";

    // prepare query
    $stmt = $this->conn->prepare($query);
    // sanitize
    $this->id_owner = htmlspecialchars(strip_tags($this->id_owner));
    $this->id_question = htmlspecialchars(strip_tags($this->id_question));
    $this->reason = htmlspecialchars(strip_tags($this->reason));
    $this->created = htmlspecialchars(strip_tags($this->created));

    // bind values
    $stmt->bindParam(":id_owner", $this->id_owner, PDO::PARAM_INT);
    $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);
    $stmt->bindParam(":reason", $this->reason, PDO::PARAM_STR);
    $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

    // execute query
    if ($stmt->execute()) {
      return 1;
    }

    return 0;
  }
}
