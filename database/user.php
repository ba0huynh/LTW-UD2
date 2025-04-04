<?php
require_once "database.php";
class UsersTable
{
    public function getUserByUsername($username)
    {
        global $pdo;
        $query = "SELECT * FROM users WHERE userName = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
   public function getUserDetailsById($userId)
    {
        global $pdo;
        $query = "SELECT * FROM users WHERE id = $userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
   public function updateUserDisplayNameById($userId, $displayName)
    {
        global $pdo;
        $query = "UPDATE users SET fullName = $displayName WHERE id = $userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
   public function updateUserStatusById($userId, $status)
    {
        global $pdo;
        $query = "UPDATE users SET status = $status WHERE id = $userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    public function getAllUser()
  {  global $pdo;
    $query = "SELECT * FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}
