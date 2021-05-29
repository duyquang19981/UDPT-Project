<?php
class admin{
  
    // database connection and table name
    private $conn;
    private $table_name = "admin";
  
    // object properties
    public $ID_ADMIN;
    public $name;
    public $USERNAME;
    public $PASS;
    public $ROLE;
    public $NOTIFICATION_YES;
    public $STATUS;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
    
        // query to insert record
        if($this -> check_username()==false)
        {
            return 2;
        }
        $query = "INSERT INTO
                    " . $this->table_name . "
                set
                name =:name,  username=:username, pass=:pass, role =:role , notification_yes =:notification_yes, status =:status";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->pass=htmlspecialchars(strip_tags($this->pass));
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->notification_yes=htmlspecialchars(strip_tags($this->notification_yes));
        $this->status=htmlspecialchars(strip_tags($this->status));
    
        // bind values
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":username", $this->username, PDO::PARAM_STR);
        $stmt->bindParam(":pass", $this->pass, PDO::PARAM_STR);
        $stmt->bindParam(":role", $this->role, PDO::PARAM_INT);
        $stmt->bindParam(":notification_yes", $this->notification_yes, PDO::PARAM_INT);
        $stmt->bindParam(":status", $this->status, PDO::PARAM_INT);

        // execute query
        if($stmt->execute()){
            return 1;
        }
    
        return 0;
        
    }

    public function login()
    {
        $query = "SELECT
                     p.id_admin
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.username = :username and pass = :pass";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->pass=htmlspecialchars(strip_tags($this->pass));
        
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $this->pass, PDO::PARAM_STR);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->id_admin = $row['id_admin'];
        
        
    }

    function check_username(){
        $query= "SELECT count(*) as num
                FROM
                " . $this->table_name . "
                WHERE
                username = :username" ;
        
        $stmt = $this->conn->prepare($query);

        $this->username=htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $this->username, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $row['num'];
        if($num >0)
        {
            return false;
        }
        else{
            return true;
        }

    }

}
?>