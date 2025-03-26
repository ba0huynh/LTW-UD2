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
    public function searchBook($search)
    {
        global $pdo;
        $query = "SELECT * FROM books WHERE MATCH(bookName) AGAINST ($search IN BOOLEAN MODE)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getRandomBookByAmount($amount)
    {
        global $pdo;
        $query = "SELECT * FROM books ORDER BY RAND() LIMIT $amount";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      
    }
}
