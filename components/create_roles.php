<?php require '../database/database.php'; ?>
<script src="https://kit.fontawesome.com/fee9c8bda7.js" crossorigin="anonymous"></script>

<div class="create-roles-container">
        <h2>Tạo vai trò</h2>
        <div class="role-form">
            <input type="text" placeholder="Nhập tên vai trò">
            <button class="add-role">Thêm vai trò</button>
        </div>
        <table border="1">
        <thead>
            <tr>
                <th>Chức năng</th>
                <?php
                // Kết nối database
                $conn = new mysqli("localhost", "root", "", "ltw_ud2");

                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Lấy danh sách các task từ bảng tasks
                $sql = "SELECT taskName FROM tasks";
                $result = $conn->query($sql);

                $tasks = [];
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tasks[] = $row["taskName"];
                        echo "<th>" . htmlspecialchars($row["taskName"]) . "</th>";
                    }
                } else {
                    echo "<th colspan='4'>Không có dữ liệu</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Lấy danh sách các nhóm quyền (permissiongroups)
            $sql = "SELECT * FROM permissiongroups";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["permissionName"]) . "</td>";

                    // Tạo checkbox động theo số lượng task
                    foreach ($tasks as $task) {
                        echo "<td><input type='checkbox' name='permissions[" . $row["id"] . "][" . $task . "]'></td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='" . (count($tasks) + 1) . "'>Không có dữ liệu</td></tr>";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </tbody>
    </table>
    </div>
    <style>
.create-roles-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 800px;
    text-align: center;
}

.create-roles-container h2 {
    margin-bottom: 15px;
}

.create-roles-container .role-form {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}

.create-roles-container .role-form input {
    padding: 8px;
    width: 60%;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.create-roles-container .add-role {
    background-color: #007bff;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.create-roles-container .add-role:hover {
    background-color: #0056b3;
}

.create-roles-container table {
    width: 100%;
    border-collapse: collapse;
}

.create-roles-container th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.create-roles-container th {
    background-color: #007bff;
    color: white;
}

.create-roles-container td input {
    width: 20px;
    height: 20px;
    cursor: pointer;
}
</style>