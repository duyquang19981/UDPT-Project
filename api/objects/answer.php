<?php
class answer
{

    // database connection and table name
    private $conn;
    private $table_name = "answer";

    // object properties
    public $id_answer;
    public $id_question;
    public $id_user;
    public $mod_id;
    public $content;
    public $created;
    public $accept_day;
    public $referencelink;
    public $referenceimage;
    public $status;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {
      //
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
        //
    }

    function accept()
    {
        $query = "UPDATE 
                    " . $this->table_name . "
                SET 
                mod_id = :mod_id, 
                accept_day = :accept_day 
                WHERE id_answer =:id_answer";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->mod_id = htmlspecialchars(strip_tags($this->mod_id));
        $this->accept_day = htmlspecialchars(strip_tags($this->accept_day));
        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        // bind values
        $stmt->bindParam(":mod_id", $this->mod_id, PDO::PARAM_INT);
        $stmt->bindParam(":accept_day", $this->accept_day, PDO::PARAM_STR);
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);

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
                WHERE id_answer =:id_answer";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        // bind values
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }

    function readAcceptYes()
    {
        $query = "SELECT * FROM 
        " . $this->table_name .
            " WHERE accept_day is not NULL AND mod_id is not NULL";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }

    function readAcceptNo()
    {
        $query = "SELECT * FROM 
        " . $this->table_name .
            " WHERE accept_day is NULL ";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }

    function readDeleted()
    {
        $query = "SELECT * FROM 
        " . $this->table_name .
            " WHERE status = 0 ";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }

    function readById()
    {
        $query = "SELECT * FROM 
        " . $this->table_name .
            " WHERE id_answer = :id_answer ";
        $stmt = $this->conn->prepare($query);
        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }
}
