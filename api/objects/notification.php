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

  function create_ques()
  {
    $query = "INSERT INTO
                    " . $this->table_name . " 
                set
                id_question = :id_question,
                content = :content,
                created = :created";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->created = htmlspecialchars(strip_tags($this->created));
        
        // bind values
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);
        $stmt->bindParam(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
  }
  function create_ans()
  {
    $query = "INSERT INTO
                    " . $this->table_name . " 
                set
                id_answer = :id_answer,
                content = :content,
                created = :created";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->created = htmlspecialchars(strip_tags($this->created));
        
        // bind values
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);
        $stmt->bindParam(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
  }
  function getid()
  {
    $query= "SELECT id_noti 
                FROM
                " . $this->table_name . "
                WHERE
                id_question = :id_question and
                content = :content and
                created = :created" ;
        
        $stmt = $this->conn->prepare($query);

        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->created = htmlspecialchars(strip_tags($this->created));
        
        // bind values
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);
        $stmt->bindParam(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        $stmt->execute();
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['id_noti'];
        
  }

  function getid_byanser()
  {
    $query= "SELECT id_noti 
                FROM
                " . $this->table_name . "
                WHERE
                id_answer= :id_answer and
                content = :content and
                created = :created" ;
        
        $stmt = $this->conn->prepare($query);

        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->created = htmlspecialchars(strip_tags($this->created));
        
        // bind values
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);
        $stmt->bindParam(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        $stmt->execute();
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['id_noti'];
        
  }
}
