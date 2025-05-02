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
    public function getAllBook()
    {
        global $pdo;
        $query = "SELECT * FROM books";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getSubjectNameById($sId) {
        global $pdo;
        $query = "SELECT subjectName FROM subjects WHERE id = $sId";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['subjectName'] ?? '';
    }

    public function getSubjectIdByName($name) {
        global $pdo;
        $query = "SELECT id FROM subjects WHERE subjectName = $name";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'] ?? '';
    }

    public function getBooksByCondition($cond){
        global $pdo;
        $query = $cond;
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteById($id){
        global $pdo;
        $query = "UPDATE books SET status = 0 WHERE id = $id ";
        $stmt = $pdo->prepare($query);
        return $stmt->execute();
    }

    public function getAllSubject()
    {
        global $pdo;
        $query = "SELECT * FROM subjects";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateBook($id, $name, $subjectId, $class, $image, $description) {
        global $pdo;
        $query = "UPDATE books SET 
                bookName = ?, 
                subjectId = ?, 
                classNumber = ?, 
                imageURL = ?, 
                description = ?
                WHERE id = ?";
            $stmt = $pdo->prepare($query);
            return $stmt->execute([$name, $subjectId, $class, $image, $description, $id]);
        }

    public function changeActive($id, $isActive) {
        global $pdo;
        $query = "UPDATE books SET isActive = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $success = $stmt->execute([$isActive, $id]);
        return $success && $stmt->rowCount() > 0;
    }

    public function addBook($name, $subjectId, $class, $image, $desc) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("INSERT INTO books 
                          (bookName, subjectId, classNumber, imageURL, description, status, isActive) 
                          VALUES (?, ?, ?, ?, ?, 1, 0)");
            $success = $stmt->execute([$name, $subjectId, $class, $image, $desc]);
        
            return $success && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Database error in addBook: " . $e->getMessage());
            return false;
        }
    }

}
