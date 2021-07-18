<?php
class tag
{

    // database connection and table name
    private $conn;
    private $table_name = "tag";

    // object properties
    public $id_tag;
    public $mod_id;
    public $description;
    public $status;

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
                NULL, :mod_id, :description, :status )";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->mod_id = htmlspecialchars(strip_tags($this->mod_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // bind values
        $stmt->bindParam(":mod_id", $this->mod_id, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
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
                description = :description
                WHERE id_tag =:id_tag";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id_tag = htmlspecialchars(strip_tags($this->id_tag));
        // bind values
        $stmt->bindParam(":id_tag", $this->id_tag, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);

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
                WHERE id_tag =:id_tag";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_tag = htmlspecialchars(strip_tags($this->id_tag));

        // bind values
        $stmt->bindParam(":id_tag", $this->id_tag, PDO::PARAM_INT);
        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }

    function fillbydescription()
    {
        $query= "SELECT id_tag 
                FROM
                " . $this->table_name . "
                WHERE
                description = :description" ;
        
        $stmt = $this->conn->prepare($query);

        $this->description=htmlspecialchars(strip_tags($this->description));
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt;
        
    }
    
    function getbyquesid($ques)
    {
        $query = "SELECT
                    t.DESCRIPTION
                FROM
                    ".$this->table_name." as t, question_tag as qt
                WHERE
                    qt.QUESTION_ID = ".$ques." and t.ID_TAG=qt.TAG_ID";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
        
    }
}
