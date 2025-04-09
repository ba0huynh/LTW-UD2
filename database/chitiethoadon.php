<?php
require_once "database.php";

class ChiTietHoadonTable
{

    public function getById($id)
    {
        global $pdo;
        $query = "SELECT * FROM chitiethoadon WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getAll(){
        global $pdo;
        $query = "SELECT * FROM chitiethoadon";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
   
}
