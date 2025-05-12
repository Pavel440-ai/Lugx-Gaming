<?php
namespace classes;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    // Initialize connection parameters in the constructor
    public function __construct($db_name = "lugx_db", $host = "localhost", $username = "root", $password = "")
    {
        $this->host     = $host;
        $this->db_name  = $db_name;
        $this->username = $username;
        $this->password = $password;
    }

    // Create and return a PDO connection to the database
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>