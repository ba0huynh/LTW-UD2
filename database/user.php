<?php

class UsersTable
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE users.email = $email";
    }
    public function createUser($email, $password, $name, $profileImage) {
        $query = "INSERT INTO `users` (`roleId`, `fullName`, `phoneNumber`, `userName`, `password`, `email`, `avatar`, `status`) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([]);
    }
}

