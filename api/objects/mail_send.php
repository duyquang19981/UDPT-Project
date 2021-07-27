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

    function create()
    {
        $query = "INSERT INTO
                    " . $this->table_name . "
                set
                 email=:email";
    
        // prepare query
        $stmt = $this->conn->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);

        if($stmt->execute()){
            return 1;
        }
    
        return 0;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_email=:id_email";

    // prepare query
    $stmt = $this->conn->prepare($query);

    $this->id_email=htmlspecialchars(strip_tags($this->id_email));

    $stmt->bindParam(":id_email", $this->id_email, PDO::PARAM_INT);

    if($stmt->execute()){
    return 1;
    }

    return 0;
    }
}