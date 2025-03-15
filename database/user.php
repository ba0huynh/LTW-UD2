<?php
require_once "database.php";
class UsersTable
{
    function getUserDetailsById($userId)
    {
        global $pdo;
        $query = "SELECT * FROM users WHERE id = $userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function updateUserDisplayNameById($userId, $displayName)
    {
        global $pdo;
        $query = "UPDATE users SET fullName = $displayName WHERE id = $userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    function updateUserStatusById($userId, $status)
    {
        global $pdo;
        $query = "UPDATE users SET status = $status WHERE id = $userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
}
