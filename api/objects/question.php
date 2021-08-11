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
    // for pagination
    public $limit = 8;     //the number of questions per page
    public $offset = 0;

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
                owner_id = :owner_id,
                category_id = :category_id,
                description = :description,
                likes = 0,
                created = :created,
                status = 1 ";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->created = htmlspecialchars(strip_tags($this->created));
        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }

    function readAll()
    {
        //for admin site
        $query = "SELECT * FROM 
                    " . $this->table_name .
            " ORDER BY `CREATED` DESC";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }

    function castQuestionRow($row)
    {
        extract($row);
        $ques = array(
            "id_question" => $ID_QUESTION,
            "owner_id" => $OWNER_ID,
            "category_id" => $CATEGORY_ID,
            "mod_id" => $MOD_ID,
            "description" => $DESCRIPTION,
            "likes" => $LIKES,
            "created" => $CREATED,
            "accept_day" => $ACCEPT_DAY,
            "status" => $STATUS,
            "comment" => 0,
            "tags" => [],
            "category_name" => $CATNAME,
            "id_user" => $ID_USER,
            "name" => $NAME,
            "image" => $IMAGE,
            "email" => $EMAIL,
            "birth" => $BIRTH,
            "phone" => $PHONE,
            "status" => $STATUS,
            "created" => $CREATED,
        );
        return $ques;
    }

    function readByCategoryId()
    {
        //for user site
        $select_field = 'C.CATEGORY_ID, C.NAME as CATNAME, C.MOD_ID, C.STATUS, C.CREATED';
        if ($this->category_id != -1) {
            $query = "SELECT " . $select_field . ", Q.*,U.* FROM 
            " . $this->table_name . " Q, category_ques C," .
                " user_account U " .
                " WHERE Q.category_id = :category_id" .
                " AND Q.category_id = C.category_id" .
                " AND Q.OWNER_ID = U.ID_USER" .
                " AND Q.status = 1" .
                " AND Q.mod_id is not NULL" .
                " ORDER BY Q.CREATED DESC" .
                " LIMIT " . $this->limit .
                " OFFSET " . $this->offset;

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        } else {
            $query = "SELECT " . $select_field . ", Q.*,U.* FROM 
            " . $this->table_name . " Q, category_ques C," .
                " user_account U " .
                " WHERE Q.category_id = C.category_id" .
                " AND Q.OWNER_ID = U.ID_USER" .
                " AND Q.status = 1" .
                " AND Q.mod_id is not NULL" .
                " ORDER BY Q.CREATED DESC" .
                " LIMIT " . $this->limit .
                " OFFSET " . $this->offset;
            $stmt = $this->conn->prepare($query);
        }
        // bind values
        if ($stmt->execute()) {
            $questions = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($questions, $this->castQuestionRow($row));
            }
            return $questions;
        }
        return 0;
    }

    function readAcceptedAndNotDeleted()
    {
        //for user site
        $query = "SELECT * FROM 
            " . $this->table_name .
            " WHERE status = 1" .
            " AND mod_id is not NULL" .
            " ORDER BY `CREATED` DESC";

        $stmt = $this->conn->prepare($query);
        // bind values
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $ques = array(
                        "id_question" => $ID_QUESTION,
                        "owner_id" => $OWNER_ID,
                        "category_id" => $CATEGORY_ID,
                        "mod_id" => $MOD_ID,
                        "description" => $DESCRIPTION,
                        "likes" => $LIKES,
                        "created" => $CREATED,
                        "accept_day" => $ACCEPT_DAY,
                        "status" => $STATUS,
                        "tags" => []

                    );

                    $tag = new tag($db);
                    $temp = $tag->getbyquesid($ques["id_question"]);
                    $tags = array();
                    // while ($row = $temp->fetch(PDO::FETCH_ASSOC)) {
                    while (0) {

                        extract($row);
                        $tag = array(
                            "DESCRIPTION" => $DESCRIPTION,
                        );

                        array_push($ques["tags"], $tag);
                    }

                    $cate = new category_ques($db);
                    $ques["category_name"] = $cate->getNamebyid($ques["category_id"]);
                    $answer = new answer($db);
                    $answer->id_question =  $ques["id_question"];
                    $stmt1 =  $answer->readByQuesID();
                    $ques["comment"] = $stmt1->rowCount();

                    array_push($res["questions"], $ques);
                }

                $res["result"] = "true";
                http_response_code(200);
                // tell the user
                echo json_encode(array(
                    "message" => "done",
                    "res" => $res
                ));
            }
            return $stmt;
        }

        return 0;
    }

    function countByCategoryId()
    {
        //count total questions by cate id
        //for user site

        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        if ($this->category_id != -1) {
            $query = "SELECT COUNT(*) FROM 
            " . $this->table_name .
                " WHERE category_id = :category_id" .
                " AND status = 1" .
                " AND mod_id is not NULL";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        } else {
            $query = "SELECT COUNT(*) FROM 
            " . $this->table_name .
                " WHERE status = 1" .
                " AND mod_id is not NULL";
            $stmt = $this->conn->prepare($query);
        }
        // bind values
        if ($stmt->execute()) {
            return $stmt;
        }

        return 0;
    }


    function update()
    {
        $query = "UPDATE " . $this->table_name . " 
        SET 
        category_id = :category_id,
        description = :description
        WHERE id_question = :id_question";

        $stmt = $this->conn->prepare($query);

        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        // bind values
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);
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
    function getIDafterCreate()
    {
        $query = "SELECT id_question FROM 
        " . $this->table_name .
            " WHERE category_id = :category_id and description = :description and created = :created and owner_id = :owner_id limit 0,1";
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->owner_id = htmlspecialchars(strip_tags($this->owner_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":owner_id", $this->owner_id, PDO::PARAM_INT);
        $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
        $stmt->bindParam(":created", $this->created, PDO::PARAM_STR);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['id_question'];
    }

    function getlist($id)
    {
        $query = "SELECT * FROM 
                    " . $this->table_name . " where owner_id = " . $id . " ORDER BY
                    mod_id ASC,
                    created ASC,
                    status DESC";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    function read_one()
    {
        // query to read single record
        $query = "SELECT
                    p.id_question, p.owner_id,p.category_id, p.description, p.likes, p.created,p.status
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.id_question = ? and p.status = 1
                LIMIT
                    0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_question);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->owner_id = $row['owner_id'];
        $this->category_id = $row['category_id'];
        $this->description = $row['description'];
        $this->likes = $row['likes'];
        $this->status = $row['status'];
        $this->created = $row['created'];
    }

    function get_maxid_ques($id)
    {
        $query = 'SELECT count(id_question) as max FROM ' . $this->table_name . ' where id_question = ' . $id . ' and status = 1 and mod_id is not null';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max'];
    }

    function get_like()
    {
        $query = "SELECT likes FROM " . $this->table_name . " WHERE id_question = :id_question limit 0,1";

        $stmt = $this->conn->prepare($query);

        $this->id_question = htmlspecialchars(strip_tags($this->id_question));

        // bind values
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['likes'];
    }

    function update_like($like)
    {
        $query = "UPDATE " . $this->table_name . " SET LIKES = " . $like . " WHERE id_question = :id_question";

        $stmt = $this->conn->prepare($query);
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));
        // bind values
        $stmt->bindParam(":id_question", $this->id_question, PDO::PARAM_INT);
        // execute query
        if ($stmt->execute()) {
            return 1;
        }

        return 0;
    }
}
