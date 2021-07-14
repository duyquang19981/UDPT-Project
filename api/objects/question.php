<?php
class question
{

    // database connection and table name
    private $conn;
    private $table_name = "question";

    // object properties
    public $id_question;
    public $owner_id;
    public $category_id;
    public $mod_id;
    public $description;
    public $likes;
    public $created;
    public $accept_day;
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
                NULL, :owner_id, :category_id,: mod_id, :description,
                :likes, :created, :accept_day, :status )";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->mod_id = htmlspecialchars(strip_tags($this->mod_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->likes = htmlspecialchars(strip_tags($this->likes));
        $this->created = htmlspecialchars(strip_tags($this->create));
        $this->accept_day = htmlspecialchars(strip_tags($this->accept_day));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(":mod_id", $this->mod_id, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
        $stmt->bindParam(":likes", $this->likes, PDO::PARAM_INT);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);
        $stmt->bindParam(":accept_day", $this->accept_day, PDO::PARAM_STR);
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
        //
    }

    function accept()
    {
        $query = "UPDATE 
                    " . $this->table_name . "
                SET 
                mod_id = :mod_id, 
                accept_day = :accept_day 
                WHERE id_question =:id_question";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->mod_id = htmlspecialchars(strip_tags($this->mod_id));
        $this->accept_day = htmlspecialchars(strip_tags($this->accept_day));
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        // bind values
        $stmt->bindParam(":mod_id", $this->mod_id, PDO::PARAM_INT);
        $stmt->bindParam(":accept_day", $this->accept_day, PDO::PARAM_STR);
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);

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
                WHERE id_question =:id_question";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        // bind values
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);

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
            " WHERE id_question = :id_question ";
        $stmt = $this->conn->prepare($query);
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }

    function countQuesCheck()
    {
        $query = "SELECT
        COUNT(*) as total_rows
        FROM
            " . $this->table_name . " p
        WHERE
            p.mod_id is null";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
    function get3quesCheck()
    {
        $query = "SELECT
        u.NAME,
        u.IMAGE,
        q.DESCRIPTION,
        q.ID_QUESTION,
        q.CREATED
        FROM
            question AS q,
            user_account AS u
        WHERE
            q.OWNER_ID = u.ID_USER AND q.MOD_ID IS NULL
        ORDER BY
            q.CREATED
        DESC
        LIMIT 0, 3";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
}
