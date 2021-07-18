<?php
class category_ques
{

    // database connection and table name
    private $conn;
    private $table_name = "category_ques";

    // object properties
    public $category_id;
    public $mod_id;
    public $name;
    public $status;
    public $created;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
        $query = "INSERT INTO
                    " . $this->table_name . "
                VALUES(
                NULL, :mod_id, :name, :created, :status )";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->mod_id = htmlspecialchars(strip_tags($this->mod_id));
        $this->created = htmlspecialchars(strip_tags($this->created));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // bind values
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":mod_id", $this->mod_id, PDO::PARAM_INT);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);
        $stmt->bindParam(":status", $this->status, PDO::PARAM_INT);

        // execute query
        if ($stmt->execute()) {
            return 1;
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

    function update()
    {
        $query = "UPDATE 
                    " . $this->table_name . "
                SET 
                name = :name
                WHERE category_id =:category_id";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        // bind values
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }

    function delete()
    {
        $query = "UPDATE 
                " . $this->table_name . "
            SET 
            status = 0
            WHERE category_id =:category_id";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // bind values
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }

    function getNamebyid($id)
    {
        $query = "SELECT name FROM 
                    " . $this->table_name. " where category_id = ".$id ;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['name'];
        
    }
}
