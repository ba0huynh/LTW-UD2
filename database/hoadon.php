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
    public function getAllHoaDon()
    {
        global $pdo;
        $query = "SELECT * FROM hoadon";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getlast6Monthstotal()
    {
        global $pdo;
        $query = "SELECT 
    DATE_FORMAT(`Date`, '%Y-%m') AS month,
    SUM(`totalBill`) AS total_bill
FROM `hoadon`
WHERE `Date` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
GROUP BY month
ORDER BY month";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
