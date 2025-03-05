<?php

    class user {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function selectAll () {
            $sql = "SELECT * FROM users";
            return $this->db->selectAll($sql);
        }

        public function selectById ($id) {
            $sql = "SELECT *
            FROM users JOIN ROLES ON users.idRole = roles.idRole
            WHERE idUser = $id";
            return $this->db->selectAll($sql);
        }

        public function selectByPhoneNumber ($phoneNumber) {
            $sql = "SELECT * FROM users WHERE phoneNumber = ?";
            return $this->db->selectBy($sql, [$phoneNumber]);
        }

        public function selectAddressById ($id) {
            $sql = "SELECT * FROM userShippingAddress WHERE idUser = $id ORDER BY STATUS DESC";
            return $this->db->selectAll($sql);
        }

        public function selectDetailAddressByIdAddress ($id) {
            $sql = "SELECT * FROM userShippingAddress WHERE idAddress = $id";
            $result = $this->db->selectAll($sql);
            return $result->fetch_assoc();
        }

        public function selectByUsername ($username) {
            $sql = "SELECT * FROM users WHERE username = ?";
            return $this->db->selectBy($sql, [$username]);
        }

        public function selectByCondition ($condition) {
            return $this->db->selectAll($condition);
        }

        public function checkRegister ($phoneNumber, $username) {
            $checkPhone = $this->selectByPhoneNumber($phoneNumber);
            if ($checkPhone->num_rows > 0) {
                return "Số điện thoại đã tồn tại";
            }

            $checkUsername = $this->selectByUsername($username);
            if ($checkUsername->num_rows > 0) {
                return "Tên tài khoản đã tồn tại";
            }

            return "";
        }

        public function checkEmail ($email) {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $this->db->selectAll ($sql);
            if ($result->num_rows > 0) {
                return "Email đã đăng ký";
            }
            return "";
        }

        public function checkEmailUpdate ($email, $id) {
            $sql = "SELECT * FROM users WHERE email = '$email' AND idUser != $id";
            $result = $this->db->selectAll ($sql);
            if ($result->num_rows > 0) {
                return "Email đã đăng ký";
            }
            return "";
        }

        public function checkLogin ($username, $password) {
            $sql = "SELECT * FROM users WHERE username = ?";
            $user = $this->db->selectBy($sql, [$username]);
            if ($user->num_rows == 0) {
                return "Tên đăng nhập hoặc mật khẩu không chính xác";
            }
            else {
                $user = $user->fetch_assoc();
                if (!password_verify($password, $user['password'])) {
                    return "Tên đăng nhập hoặc mật khẩu không chính xác";
                }
                if ($user['status'] == 0) {
                    return "Tài khoản của bạn đã bị khóa";
                }
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['account_login'] = $user;
                if ($_SESSION['account_login']['idRole'] != 1) {
                    return "admin";
                }
                return "";
            }
        }

        public function loginWithEmail ($email, $name, $avatar) {
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $this->db->selectAll ($sql);
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO users(email, fullname, avatar) VALUES('$email', '$name', '$avatar')";
                $id = $this->db->insert($sql);
                $sql = "SELECT * FROM users WHERE idUser = $id";
                $result = $this->db->selectAll($sql);
                $result = $result->fetch_assoc();
                session_start();
                $_SESSION['account_login'] = $result;
                return "";
            }
            $result = $result->fetch_assoc();
            if ($result['status'] == 0) {
                return "Tài khoản của bạn bị khóa";
            }
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['account_login'] = $result;
            // return $result;
            if ($_SESSION['account_login']['idRole'] != 1) {
                return 'admin';
            }
            return "";
        }

        public function insertRegister ($data) {
            $fullname = $data[0];
            $phoneNumber = $data[1];
            $username = $data[2];
            $password = password_hash($data[3], PASSWORD_BCRYPT);
            $avatar = $data[4];
            $sql = "INSERT INTO users(fullname, phoneNumber, username, password, avatar) VALUES('$fullname', '$phoneNumber', '$username', '$password', '$avatar')";
            return $this->db->insert($sql);
        }

        public function insertAddress ($id, $name, $address, $phone) {
            $sql = "INSERT INTO userShippingAddress(idUser, name, address, phoneNumber) VALUES($id, '$name', '$address', '$phone')";
            return $this->db->insert($sql);
        }

        public function insertStaff ($idRole, $name, $phoneNumber, $email, $username, $password, $avatar) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            if ($email == "") {
                $sql = "INSERT INTO users(idRole, fullname, phoneNumber, username, password, avatar) VALUES($idRole, '$name', '$phoneNumber', '$username', '$password', '$avatar')";
                return $this->db->insert($sql);
            }
            $sql = "INSERT INTO users(idRole, fullname, phoneNumber, email, username, password, avatar) VALUES($idRole, '$name', '$phoneNumber', '$email', '$username', '$password', '$avatar')";
            return $this->db->insert($sql);
        }

        public function updateAvatar ($id, $avatar) {
            $sql = "UPDATE users SET avatar = '$avatar' WHERE idUser = $id";
            return $this->db->update($sql);
        }

        public function updateStaff ($id, $fullname, $phoneNumber, $idRole, $email, $avatar) {
            if ($email == "Không có") {
                $sql = "UPDATE users SET fullname = '$fullname', phoneNumber = '$phoneNumber', idRole = $idRole
                WHERE idUser = $id";
                $this->db->update($sql);
            }
            else {
                $check = $this->checkEmailUpdate($email, $id);
                if ($check == "") {
                    $sql = "UPDATE users SET fullname = '$fullname', phoneNumber = '$phoneNumber', idRole = $idRole, email = '$email', WHERE idUser = $id";
                    $this->db->update($sql);
                }
                else {
                    return $check;
                }
            }

            if ($avatar != '') {
                require_once __DIR__ . '/../handle.php';
                $avatar = uploadsAvatar($avatar, $id);
                $sql = "UPDATE USERS SET AVATAR = '$avatar' WHERE IDUSER = $id";
                return $this->db->update($sql);
            }
        }

        public function updateStaffDefaultAvatar ($id, $fullname, $phoneNumber, $idRole, $email) {
            $avatar = "./avatar/default-avatar.jpg";
            if ($email == "Không có") {
                $sql = "UPDATE users SET fullname = '$fullname', phoneNumber = '$phoneNumber', idRole = $idRole,
                avatar = '$avatar'
                WHERE idUser = $id";
            }
            else {
                $check = $this->checkEmailUpdate($email, $id);
                if ($check == "") {
                    $sql = "UPDATE users SET fullname = '$fullname', phoneNumber = '$phoneNumber', idRole = $idRole, email = '$email', avatar = '$avatar'
                    WHERE idUser = $id";
                }
                else {
                    return $check;
                }
            }
            // return $sql;
            return $this->db->update($sql);
        }

        public function updateDefaultAddress ($id, $name, $address, $phone) {
            $sql = "UPDATE userShippingAddress SET status = 0 WHERE idUser = $id";
            $this->db->update($sql);
            $sql = "UPDATE userShippingAddress SET status = 1 WHERE idUser = $id AND name = '$name' AND address = '$address' AND phoneNumber = '$phone'";
            return $this->db->update($sql);
        }

        public function updateAddress ($id, $name, $address, $phone, $oldName, $oldAddress, $oldPhone) {
            $sql = "UPDATE userShippingAddress SET name = '$name', address = '$address', phoneNumber = '$phone' WHERE idUser = $id AND name = '$oldName' AND address = '$oldAddress' AND phoneNumber = '$oldPhone'";
            return $this->db->update($sql);
        }

        public function deleteAddress ($id, $name, $address, $phone) {
            $sql = "DELETE FROM userShippingAddress WHERE idUser = $id AND name = '$name' AND address = '$address' AND phoneNumber = '$phone'";
            return $this->db->delete($sql);
        }

        public function deleteStaff ($id) {
            $sql = "UPDATE users SET statusRemove = 1 WHERE idUser = $id";
            return $this->db->update($sql);
        }

        public function getQuantityCustomer () {
            $sql = "SELECT * FROM users WHERE IDROLE = 1";
            return $this->db->selectAll($sql)->num_rows;
        }

        public function getQuantityNewCustomer () {
            $sql = "SELECT *
            FROM users
            WHERE IDROLE = 1 AND CREATEAT >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
            return $this->db->selectAll($sql)->num_rows;
        }

        public function getQuantityCustomerByMonth () {
            $sql = "SELECT MONTH(CREATEAT) AS MONTH, COUNT(*) AS QUANTITY
            FROM USERS
            WHERE IDROLE = 1
            AND YEAR(CREATEAT) = YEAR(CURDATE())
            GROUP BY MONTH(CREATEAT)";
            $result = $this->db->selectAll($sql);

            $data = [
                'customer' => [],
                'customerNew' => []
            ];
            while ($row = $result->fetch_assoc()) {
                $data['customer'][] = $row;
            }

            $sql = "SELECT MONTH(CREATEAT) AS MONTH, COUNT(*) AS QUANTITY
            FROM USERS
            WHERE IDROLE = 1
            AND YEAR(CREATEAT) = YEAR(CURDATE())
            AND CREATEAT >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
            GROUP BY MONTH(CREATEAT)";
            $result = $this->db->selectAll($sql);
            while ($row = $result->fetch_assoc()) {
                $data['customerNew'][] = $row;
            }

            return $data;
        }

        public function getAllCustomer () {
            $sql = "SELECT *
            FROM USERS
            WHERE IDROLE = 1";
            return $this->db->selectAll($sql);
        }

        public function blockUser ($id) {
            $sql = "UPDATE USERS SET STATUS = 0 WHERE IDUSER = $id";
            return $this->db->update($sql);
        }

        public function unblockUser ($id) {
            $sql = "UPDATE USERS SET STATUS = 1 WHERE IDUSER = $id";
            return $this->db->update($sql);
        }
    }

?>