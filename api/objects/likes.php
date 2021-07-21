<?php
class likes
{

    // database connection and table name
    private $conn;
    private $table_name = "likes";

    // object properties
    public $id_like;
    public $owner_id;
    public $question_id;
    public $answer_id;
    public $created;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    function create_ques()
    {
        $query = "INSERT INTO
                    " . $this->table_name . " 
                set
                owner_id = :owner_id,
                question_id = :question_id,
                created = :created";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $this->created = htmlspecialchars(strip_tags($this->created));
        
        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":question_id", $this->question_id, PDO::PARAM_INT);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }
    function create_ans()
    {
        $query = "INSERT INTO
                    " . $this->table_name . " 
                set
                owner_id = :owner_id,
                answer_id = :answer_id,
                created = :created";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->answer_id = htmlspecialchars(strip_tags($this->answer_id));
        $this->created = htmlspecialchars(strip_tags($this->created));
        
        // bind values  
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":answer_id", $this->answer_id, PDO::PARAM_INT);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }
    function check_ques()
    {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " 
        where 
        owner_id = :owner_id and 
        question_id = :question_id ";
    
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));;
        
        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":question_id", $this->question_id, PDO::PARAM_INT);
    
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }
    function check_ans()
    {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " 
        where 
        owner_id = :owner_id  and 
        answer_id = :answer_id";
    
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->answer_id = htmlspecialchars(strip_tags($this->answer_id));;
        
        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":answer_id", $this->answer_id, PDO::PARAM_INT);
    
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }

    function delete_ques()
    {
        $query = "DELETE FROM " . $this->table_name . " 
        where 
        owner_id = :owner_id and 
        question_id = :question_id ";

        $stmt = $this->conn->prepare( $query );
        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));;
        
        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":question_id", $this->question_id, PDO::PARAM_INT);
    
        // execute query
        if ($stmt->execute()) {
            return 1;
            }
    
            return 0;
    }
    function delete_ans()
    {
        $query = "DELETE FROM " . $this->table_name . " 
        where 
        owner_id = :owner_id  and 
        answer_id = :answer_id";
    
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->answer_id = htmlspecialchars(strip_tags($this->answer_id));;
        
        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":answer_id", $this->answer_id, PDO::PARAM_INT);
    
    
        // execute query
        if ($stmt->execute()) {
            return 1;
            }
    
            return 0;
    }
}