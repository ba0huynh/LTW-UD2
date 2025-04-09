<?php
require_once "database.php";

class HoadonTable
{

    public function getHoaDonById($id)
    {
        global $pdo;
        $query = "SELECT * FROM hoadon WHERE id = $id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getAllHoaDon(){
        global $pdo;
        $query = "SELECT * FROM hoadon";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
   
}
