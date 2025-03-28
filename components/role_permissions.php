<?php require '../database/database.php'; ?>
<script src="https://kit.fontawesome.com/fee9c8bda7.js" crossorigin="anonymous"></script>
<div class="role-permissions-container">
    <h2>Quản lý vai trò</h2>
    <table>
        <thead>
            <tr>
                <th>VAI TRÒ</th>
                <th>TÊN VAI TRÒ</th>
                <th>NGÀY TẠO</th>
                <th>NGÀY CHỈNH SỬA</th>
                <th>CHỨC NĂNG</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Kết nối database
            $conn = new mysqli("localhost", "root", "", "ltw_ud2");

            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Truy vấn dữ liệu từ bảng roles
            $sql = "SELECT * FROM roles";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["idRole"] . "</td>";
                    echo "<td>" . $row["roleName"] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["created_at"])) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["updated_at"])) . "</td>";
                    echo "<td>
                            <button class='delete-icon'><i class='fa-solid fa-trash'></i></button>
                            <button class='edit-icon'><i class='fa-solid fa-pen-to-square'></i></button>
                            <button class='view-icon'><i class='fa-solid fa-eye'></i></button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Không có dữ liệu</td></tr>";
            }
            

            // Đóng kết nối
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
<style>
    .role-permissions-container{
        width: 80%;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .role-permissions-container h2 {
        text-align: left;
        margin-bottom: 10px;
    }

    .role-permissions-container table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .role-permissions-container th,
    .role-permissions-container td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .role-permissions-container th {
        background-color: #f2f2f2;
    }

    .role-permissions-container tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .role-permissions-container td i {
        margin: 0 5px;
        cursor: pointer;
    }
    .role-permissions-container .delete-icon,.edit-icon,.view-icon {
        background: none;
        border: none;
        cursor: pointer;
    }
    .role-permissions-container .delete-icon {
        color: red;
    }

    .role-permissions-container .edit-icon {
        color: blue;
    }

    .role-permissions-container .view-icon {
        color: green;
    }
</style>