<?php
require_once "database.php";

class BooksTable
{

    public function getBookById($id)
    {
        global $pdo;
        $query = "SELECT * FROM books WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
