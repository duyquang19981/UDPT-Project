<?php
class category_ques{
  
    // database connection and table name
    private $conn;
    private $table_name = "category_ques";
  
    // object properties
    public $id_category_ques;
    public $mod_id;
    public $category_id;
    public $name;
    public $status;
    public $created;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    
    
}
?>