<?php
    session_start();
    include 'connect.php';

    $message = '';
    $messageType = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $sql = "SELECT id, ten_dang_nhap FROM nguoi_dung
                WHERE ten_dang_nhap = ? AND mat_khau = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['username'] = $user['ten_dang_nhap'];
            header ("Location: index.php");
            exit();
        } else {
            $message = 'Đăng nhập thất bại';
            $messageType = 'error';
        }

        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="password"] {
            /* width: 100%; */
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 15px;
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: bold;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
        }
    </style>
    <link rel="stylesheet" href="admin.css">
    <title>Document</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"  required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <?php if ($message !== ''): ?>
        <div class="message <?= htmlspecialchars($messageType) ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
</body>
</html>