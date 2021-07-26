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
    public $likes;
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
        set
        id_question = :id_question,
        id_user = :id_user,
        content = :content,
        referencelink = :referencelink,
        referenceimage = :referenceimage,
        created = :created,
        status = 1,
        likes = 0 ";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->referencelink = htmlspecialchars(strip_tags($this->referencelink));
        $this->referenceimage = htmlspecialchars(strip_tags($this->referenceimage));
        $this->created = htmlspecialchars(strip_tags($this->created));
        // bind values
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);
        $stmt->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);
        $stmt->bindParam(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindParam(":referencelink", $this->referencelink, PDO::PARAM_STR);
        $stmt->bindParam(":referenceimage", $this->referenceimage, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
        return 1;
        }

        return 0;
    }

    function getIDafterCreate()
    {
        $query = "SELECT id_answer FROM 
        " . $this->table_name .
            " WHERE id_question = :id_question and
            id_user = :id_user and
            content = :content and
            referencelink = :referencelink and
            referenceimage = :referenceimage and
            created = :created limit 0,1";
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->referencelink = htmlspecialchars(strip_tags($this->referencelink));
        $this->referenceimage = htmlspecialchars(strip_tags($this->referenceimage));
        $this->created = htmlspecialchars(strip_tags($this->created));
        // bind values
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);
        $stmt->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);
        $stmt->bindParam(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindParam(":referencelink", $this->referencelink, PDO::PARAM_STR);
        $stmt->bindParam(":referenceimage", $this->referenceimage, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['id_answer'];
    }

    function readAll()
    {
        $query = "SELECT * FROM 
                    " . $this->table_name .
            " ORDER BY `CREATED` DESC";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }

    function update()
    {
        $query ="UPDATE " . $this->table_name." 
        SET 
        referencelink = :referencelink,
        content = :content,
        referenceimage = :referenceimage
        WHERE id_answer = :id_answer";

        $stmt = $this->conn->prepare($query);

        $this->referencelink = htmlspecialchars(strip_tags($this->referencelink));
        $this->referenceimage = htmlspecialchars(strip_tags($this->referenceimage));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        // bind values

        $stmt->bindParam(":referencelink", $this->referencelink, PDO::PARAM_STR);
        $stmt->bindParam(":referenceimage", $this->referenceimage, PDO::PARAM_STR);
        $stmt->bindParam(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);
        // execute query
        if ($stmt->execute()) {
            return 1;
            }
    
            return 0;
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
            " WHERE accept_day is not NULL AND mod_id is not NULL" .
            " ORDER BY `CREATED` DESC";
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
            " WHERE accept_day is NULL " .
            " ORDER BY `CREATED` DESC";
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
            " WHERE status = 0 " .
            " ORDER BY `CREATED` DESC";
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

    function readByQuesID()
    {
        $query = "SELECT p.id_answer, p.id_question,p.id_user,p.content,p.created,p.referencelink,p.referenceimage,p.likes,p.status
         FROM 
        " . $this->table_name . " as p" .
            " WHERE p.id_question = :id_question and p.status = 1 and p.mod_id is not null";
        $stmt = $this->conn->prepare($query);

        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }
    function readByUserID()
    {
        $query = "SELECT p.id_answer, p.id_question,p.id_user,p.content,p.created,p.referencelink,p.referenceimage,p.likes,p.status,p.mod_id
         FROM 
        " . $this->table_name . " as p" .
            " WHERE p.id_user = :id_user ORDER BY
            mod_id ASC,
            created ASC, 
            status ASC";
        $stmt = $this->conn->prepare($query);

        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $stmt->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }

    function get_like()
    {
        $query ="SELECT likes FROM " . $this->table_name." WHERE id_answer = :id_answer limit 0,1";

        $stmt = $this->conn->prepare($query);

        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        
        // bind values
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);
    
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['likes'];
    }

    function update_like($like)
    {
        $query ="UPDATE " . $this->table_name." SET LIKES = ".$like." WHERE id_answer = :id_answer";

        $stmt = $this->conn->prepare($query);
        $this->id_answer = htmlspecialchars(strip_tags($this->id_answer));
        // bind values
        $stmt->bindParam(":id_answer", $this->id_answer, PDO::PARAM_INT);
        // execute query
        if ($stmt->execute()) {
            return 1;
            }
    
            return 0;
    }
}
