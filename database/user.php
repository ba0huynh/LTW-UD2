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
    {
        global $pdo;
        $query = "SELECT * FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTop5UsersByBooksOrdered()
    {
        global $pdo;
        $query = "
      SELECT 
    u.id AS userId,
    u.username AS userName,
    SUM(h.totalBill) AS totalSpent
FROM 
    users u
JOIN 
    hoadon h ON u.id = h.idUser
WHERE 
    h.statusBill = 1 -- Only include completed orders
GROUP BY 
    u.id, u.username
ORDER BY 
    totalSpent DESC
LIMIT 5;
    ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function adminLogin($username, $password)
    {
        global $pdo;
        $query = "SELECT * FROM users WHERE role_id IS NOT NULL AND userName = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            $_SESSION["admin_id"] = $result["id"];
            return $result;
        } else {
            return false; // Return false if login fails
        }
    }
}
