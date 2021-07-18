<?php
class ques_tag
{
 
    // database connection and table name
    private $conn;
    private $table_name = "question_tag";

    // object properties
    public $qt_id;
    public $question_id;
    public $tag_id;
    

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
                question_id = :question_id,
                tag_id = :tag_id";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $this->tag_id = htmlspecialchars(strip_tags($this->tag_id));
        
        // bind values
        $stmt->bindParam(":question_id", $this->question_id, PDO::PARAM_INT);
        $stmt->bindParam(":tag_id", $this->tag_id, PDO::PARAM_INT);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }
}
