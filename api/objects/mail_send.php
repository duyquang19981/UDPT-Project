<?php
class email_send
{

    // database connection and table name
    private $conn;
    private $table_name = "email_send";

    // object properties
    public $id_email;
    public $email;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function get_all()
    {
        $query = "SELECT email FROM 
                    " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
        
    }

    function readAll(){
        $query = "SELECT * FROM 
                        " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
    }
}