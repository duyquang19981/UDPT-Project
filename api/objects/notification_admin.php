<?php
class notification_admin
{

  // database connection and table name
  private $conn;
  private $table_name = "notification_admin";

  // object properties
  public $id_na;
  public $noti_id;
  public $admin_id;
  public $status;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function readMyNoti()
  {
    $query = "SELECT * FROM 
                    " . $this->table_name . "
              WHERE admin_id =:admin_id";
    $stmt = $this->conn->prepare($query);
    $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
    $stmt->bindParam(":admin_id", $this->admin_id, PDO::PARAM_INT);

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
