<?php
class Database
{
    // specify your own database credentials
    private $host = "sql6.freemysqlhosting.net";
    private $db_name = "sql6430149";
    private $username = "sql6430149";
    private $password = "I4UrnEEINS";
    private $port = 3306;
    public $conn;

    // get the database connection
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_DATABASE'),  getenv('DB_USERNAME'),  getenv('DB_PASSWORD'));
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
