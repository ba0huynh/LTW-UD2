<?php 
require_once "database.php";

class SubjectsTable{
    public function getSubjectById($id)
    {
        global $pdo; // Add this line to access the $pdo variable from the global scope
        $query = "SELECT * FROM subjects WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(); // Bind the $id parameter
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}