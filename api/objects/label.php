<?php
class label
{

    // database connection and table name
    private $conn;
    private $table_name = "label";

    // object properties
    public $id_label;
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
                WHERE id_label =:id_label";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id_label = htmlspecialchars(strip_tags($this->id_label));
        // bind values
        $stmt->bindParam(":id_label", $this->id_label, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }

    function delete()
    {
        $query = "DELETE FROM
                    " . $this->table_name . "
                WHERE id_label =:id_label";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_label = htmlspecialchars(strip_tags($this->id_label));

        // bind values
        $stmt->bindParam(":id_label", $this->id_label, PDO::PARAM_INT);
        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }
}
