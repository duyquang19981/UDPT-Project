<?php
class user_account{
  
    // database connection and table name
    private $conn;
    private $table_name = "user_account";
  
    // object properties
    public $id_user;
    public $name;
    public $image;
    public $email;
    public $birth;
    public $phone;
    public $username;
    public $password;
    public $created;
    public $status;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT
                    p.id_user, p.name, p.image, p.email, p.birth, p.phone, p.created
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
    function check_username(){
        $query= "SELECT count(*) as num
                FROM
                " . $this->table_name . "
                WHERE
                username = :username" ;
        
        $stmt = $this->conn->prepare($query);

        $this->username=htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $this->username, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $row['num'];
        if($num >0)
        {
            return false;
        }
        else{
            return true;
        }

    }
    function check_phone(){
        $query= "SELECT count(*) as num
                FROM
                " . $this->table_name . "
                WHERE
                phone = :phone" ;
        
        $stmt = $this->conn->prepare($query);

        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $stmt->bindParam(":phone", $this->phone, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $row['num'];
        if($num >0)
        {
            return false;
        }
        else{
            return true;
        }
    }
    function check_email(){
        $query= "SELECT count(*) as num
                FROM
                " . $this->table_name . "
                WHERE
                email = :email" ;
        
        $stmt = $this->conn->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $row['num'];
        if($num >0)
        {
            return false;
        }
        else{
            return true;
        }
    }
    function create(){
    
        // query to insert record
        if($this -> check_username()==false)
        {
            return 2;
        }
        if($this -> check_email()==false)
        {
            return 3;
        }
        if($this -> check_phone()==false)
        {
            return 4;
        }
        $query = "INSERT INTO
                    " . $this->table_name . "
                set
                name =:name, email=:email, birth=:birth, phone=:phone, username=:username, password=:password, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->birth=htmlspecialchars(strip_tags($this->birth));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":birth", $this->birth, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $this->phone, PDO::PARAM_STR);
        $stmt->bindParam(":username", $this->username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $this->password, PDO::PARAM_STR);
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
                    p.id_user, p.name,p.image, p.email, p.birth, p.phone, p.created
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.id_user = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_user);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->name = $row['name'];
        $this->image = $row['image'];
        $this->email = $row['email'];
        $this->birth = $row['birth'];
        $this->phone = $row['phone'];
        $this->created = $row['created'];
    }
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    email = :email,
                    birth = :birth,
                    phone = :phone
                WHERE
                    id_user = :id_user";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->birth=htmlspecialchars(strip_tags($this->birth));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->id_user=htmlspecialchars(strip_tags($this->id_user));
    
        // bind new values
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':birth', $this->birth, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $this->id_user);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
        
        return false;
    }
    function search($keywords,$from_record_num, $records_per_page){
    
        // select all query
        $query = "SELECT
                     p.id_user, p.name, p.image, p.email, p.birth, p.phone, p.created,p.status
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.name LIKE ?
                ORDER BY
                    p.status ASC,
                    p.id_user ASC
                LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        // bind
        $stmt->bindParam(1, $keywords, PDO::PARAM_STR);
        $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    p.id_user, p.name,p.image, p.email, p.birth, p.phone, p.created, p.status
                FROM
                    " . $this->table_name . " p
                ORDER BY 
                    p.status ASC,
                    p.id_user ASC
                LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
    public function searchcount($keywords){
        $query = "SELECT
                      COUNT(*) as total_rows
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.name LIKE ?
                ORDER BY
                    p.id_user ASC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        // bind
        $stmt->bindParam(1, $keywords, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
    public function login()
    {
        $query = "SELECT
                     p.id_user,p.name,p.image,p.status,p.email
                FROM
                    " . $this->table_name . " p
                WHERE
                    p.username = :username and password = :password";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        
        $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);

        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->id_user = $row['id_user'];
        $this->name = $row['name'];
        $this->image = $row['image'];
        $this->status = $row['status'];
        $this->email = $row['email'];
        }
        
        
    }
    public function updatepass()
    {
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                password = :password
                WHERE
                    id_user = :id_user";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->id_user=htmlspecialchars(strip_tags($this->id_user));
    
        // bind new values
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
        
        return false;
    }
    public function checkk()
    {
        if($this -> check_username()==false)
        {
            return 2;
        }
        if($this -> check_email()==false)
        {
            return 3;
        }
        if($this -> check_phone()==false)
        {
            return 4;
        }
        return 1;
    }
    public function forgotpass()
    {
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                password = :password
                WHERE
                    email = :email";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->email=htmlspecialchars(strip_tags($this->email));
    
        // bind new values
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
        
        return false;
    }

    public function getnumques($id)
    {
        $query = "SELECT COUNT(*) as total_rows FROM question WHERE owner_id = ".$id ;
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }

    public function getnumans($id)
    {
        $query = "SELECT COUNT(DISTINCT ID_QUESTION) as total_rows FROM answer WHERE ID_USER =  ".$id ;
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }
    public function checkoldpass($old)
    {
        $query = "SELECT COUNT(*) as total_rows 
        FROM " . $this->table_name . " 
        WHERE id_user = ? and password = ?";
        // prepare query
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id_user, PDO::PARAM_STR);
        $stmt->bindParam(2, $old, PDO::PARAM_STR);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row['total_rows']>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function updateAvata($id, $image)
    {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    image = '".$image."'
                WHERE
                    id_user = ".(int)$id ;
        $stmt = $this->conn->prepare($query);
        
        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function updatestatus()
    {
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    status = :status
                    
                WHERE
                    id_user = :id_user";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id_user=htmlspecialchars(strip_tags($this->id_user));

        $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);

        // execute the query
        if($stmt->execute()){
            return true;
        }
        
        return false;
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

    function get_maxid_user($id)
    {
        $query = 'SELECT count(ID_USER) as max FROM ' . $this->table_name.' where ID_USER = '. $id. ' and status = 1';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max'];
    }

    public function getnumquesInMonth($id, $month)
    {
        $start = '2021-' . $month . '-1';
        $end = '2021-' . $month + 1 . '-1';

        $query = "SELECT COUNT(*) as total_rows FROM question 
        WHERE owner_id = " . $id .
            " AND  CREATED >= '" . $start . "' " .
            " AND CREATED < '" . $end . "'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }

    public function getnumansInMonth($id, $month)
    {
        $start = '2021-' . $month . '-1';
        $end = '2021-' . $month + 1 . '-1';
        $query = "SELECT COUNT(DISTINCT ID_QUESTION) as total_rows FROM answer 
        WHERE ID_USER =  " . $id .
            " AND  CREATED >= '" . $start . "' " .
            " AND CREATED < '" . $end . "'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }

    
}
