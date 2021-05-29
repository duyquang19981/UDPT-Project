<?php
class question{
  
    // database connection and table name
    private $conn;
    private $table_name = "question";
  
    // object properties
    public $id_question;
    public $owner_id;
    public $category_id;
    public $mod_id;
    public $description;
    public $like;
    public $created;
    public $accept_day;
    public $status;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function read(){
     
        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " p
                ORDER BY
                    p.created DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
}
?>