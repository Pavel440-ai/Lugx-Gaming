<?php
namespace classes;

use PDO;

// Include the Database class for connecting to the database
require_once 'Database.php';

class QnA
{
    private $conn;

    // Initialize connection in the constructor
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Retrieve all QnA entries, ordered by id in descending order
    public function getQnA()
    {
        $sql = "SELECT * FROM qna ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve a single QnA entry based on its id
    public function getQnAById($id)
    {
        $sql = "SELECT * FROM qna WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert a new QnA entry into the database
    public function insertQnA($question, $answer)
    {
        $sql = "INSERT INTO qna (question, answer) VALUES (:question, :answer)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':question' => $question,
            ':answer'   => $answer
        ]);
    }

    // Update an existing QnA entry with new values
    public function updateQnA($id, $question, $answer)
    {
        $sql = "UPDATE qna SET question = :question, answer = :answer WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':question' => $question,
            ':answer'   => $answer,
            ':id'       => $id
        ]);
    }

    // Delete a specific QnA entry based on its id
    public function deleteQnA($id)
    {
        $sql = "DELETE FROM qna WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}