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

    // function check_username(){
    //     $query= "SELECT count(*) as num
    //             FROM
    //             " . $this->table_name . "
    //             WHERE
    //             username = :username" ;
        
    //     $stmt = $this->conn->prepare($query);

    //     $this->username=htmlspecialchars(strip_tags($this->username));
    //     $stmt->bindParam(":username", $this->username, PDO::PARAM_STR);
    //     $stmt->execute();
    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //     $num = $row['num'];
    //     if($num >0)
    //     {
    //         return false;
    //     }
    //     else{
    //         return true;
    //     }

    // }
    
    function create(){
    
        // query to insert record
        // if($this -> check_username()==false)
        // {
        //     return 2;
        // }
        
        $query = "INSERT INTO
                    " . $this->table_name . "
                set
                name =:name, category_id=: category_id, mod_id =:mod_id, status =: status, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->mod_id=htmlspecialchars(strip_tags($this->mod_id));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(":mod_id", $this->mod_id, PDO::PARAM_INT);
        $stmt->bindParam(":status", $this->phone, PDO::PARAM_INT);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);
    
        // execute query
        if($stmt->execute()){
            return 1;
        }
    
        return 0;
        
    }
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.id_category_ques = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_category_ques);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->name = $row['name'];
        $this->email = $row['status'];
        $this->birth = $row['mod_id'];
        $this->phone = $row['category_id'];
        $this->created = $row['created'];
    }
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    status = :status,
                WHERE
                    id_category_ques = :id_category_ques";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id_category_ques=htmlspecialchars(strip_tags($this->id_category_ques));
    
        // bind new values
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':id_category_ques', $this->id_category_ques);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
        
        return false;
    }
    
}
?>