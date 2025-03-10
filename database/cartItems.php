<?php 
require_once "database.php";
class CartItemsTable {
    function getAllItemsFromUserId($userId) {
        global $pdo; 
        $query = "SELECT * FROM cartitems WHERE userid = $userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(); 
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}