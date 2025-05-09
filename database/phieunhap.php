<?php
require_once "database.php";

class PhieuNhap 
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM hoadonnhap WHERE id = :id AND status = 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserNameById($id)
    {
        $stmt = $this->pdo->prepare("SELECT userName FROM users WHERE id = :id AND status_user = 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['userName'] ?? '';
    }

    public function getFullNameById($id)
    {
        $stmt = $this->pdo->prepare("SELECT fullName FROM users WHERE id = :id AND status_user = 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['fullName'] ?? '';
    }

    public function deleteById($id)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("UPDATE chitietphieunhap SET status = 0 WHERE idPhieuNhap = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->pdo->prepare("UPDATE hoadonnhap SET status = 0 WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            $this->pdo->commit();
            return $result;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getByCondition($sql)
    {
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPhieuNhapPagination($offset, $itemPerPage, $search = '')
    {
        $query = "SELECT hdn.*, u.username as ten_nguoi_nhap 
                 FROM hoadonnhap hdn 
                 LEFT JOIN users u ON hdn.idNguoiNhap = u.id 
                 WHERE hdn.status = 1";

        $params = [];
        if (!empty($search)) {
            $query .= " AND hdn.idNguoiNhap IN (SELECT id FROM users WHERE userName LIKE :search AND status = 1)";
            $params[':search'] = "%$search%";
        }

        $query .= " ORDER BY hdn.date DESC LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($query);

        if (!empty($search)) {
            $stmt->bindValue(':search', $params[':search'], PDO::PARAM_STR);
        }

        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$itemPerPage, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllPhieuNhap($search = '')
    {
        $query = "SELECT COUNT(*) as total 
                 FROM hoadonnhap hdn 
                 WHERE hdn.status = 1";

        if (!empty($search)) {
            $query .= " AND hdn.idNguoiNhap IN (SELECT id FROM users WHERE userName LIKE :search AND status = 1)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        } else {
            $stmt = $this->pdo->prepare($query);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}