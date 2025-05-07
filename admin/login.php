<?php
session_start();
require_once "../database/user.php";

$usersTable = new UsersTable();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin = $usersTable->adminLogin($username, $password);

    if ($admin) {
        // Login successful
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: index.php"); // Redirect to admin dashboard
        exit();
    } else {
        // Login failed
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg border border-gray-300 rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Admin Login</h1>
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                <input type="text" name="username" id="username" class="w-full border border-gray-300 rounded-lg p-2" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg p-2" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white font-medium py-2 rounded-lg hover:bg-blue-600 transition">
                Login
            </button>
        </form>
    </div>
</body>

</html>