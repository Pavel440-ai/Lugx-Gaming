<?php
namespace classes;

use PDO;
use PDOException;

// Require the Database class for connecting to the database
require_once 'Database.php';

class Users
{
    private $conn;

    // Initialize the database connection
    public function __construct()
    {
        $database   = new Database();
        $this->conn = $database->connect();
    }

    // Retrieve all users with selected columns
    public function getAllUsers()
    {
        $sql  = "SELECT id, login, email, rola FROM users_db";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve a single user by id with selected columns
    public function getUserById($id)
    {
        $sql  = "SELECT id, login, email, rola FROM users_db WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new user. Password is hashed using the default algorithm.
    public function addUser($username, $email, $password, $rola)
    {
        $sql  = "INSERT INTO users_db (login, email, heslo, rola) VALUES (:username, :email, :password, :rola)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':rola'     => $rola
        ]);
    }

    // Delete a user by id
    public function deleteUser($id)
    {
        $sql  = "DELETE FROM users_db WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Update a user. If a new password is provided it is hashed and updated.
    public function updateUser($id, $username, $email, $password = null, $rola)
    {
        if ($password) {
            $sql = "UPDATE users_db 
                    SET login = :username, email = :email, heslo = :password, rola = :rola 
                    WHERE id = :id";
            $params = [
                ':username' => $username,
                ':email'    => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':rola'     => $rola,
                ':id'       => $id
            ];
        } else {
            $sql = "UPDATE users_db 
                    SET login = :username, email = :email, rola = :rola 
                    WHERE id = :id";
            $params = [
                ':username' => $username,
                ':email'    => $email,
                ':rola'     => $rola,
                ':id'       => $id
            ];
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Search for users by a search term in their username or email
    public function searchUsers($searchTerm)
    {
        $sql  = "SELECT id, login, email, rola 
                 FROM users_db 
                 WHERE login LIKE :search OR email LIKE :search";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':search' => "%" . $searchTerm . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>