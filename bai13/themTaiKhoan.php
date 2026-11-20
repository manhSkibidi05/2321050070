<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
        }
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
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
    </style>
    <title>Document</title>
</head>
<body>
    <h1>Thêm Tài Khoản</h1>
    <form action="" method="POST">
        <label for="ten_dang_nhap">Tên đăng nhập:</label>
        <input type="text" id="ten_dang_nhap" name="ten_dang_nhap" required><br><br>

        <label for="mat_khau">Mật khẩu:</label>
        <input type="text" id="mat_khau" name="mat_khau" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="ho_ten">Họ tên:</label>
        <input type="text" id="ho_ten" name="ho_ten" required><br><br>

        <label for="so_dien_thoai">Số điện thoại:</label>
        <input type="text" id="so_dien_thoai" name="so_dien_thoai" required><br><br>

        <label for="ngay_sinh">Ngày sinh:</label>
        <input type="date" id="ngay_sinh" name="ngay_sinh" required><br><br>

        <label for="gioi_tinh">Giới tính:</label>
        <input type="radio" id="nam" name="gioi_tinh" value="1" required>
        <label for="nam">Nam</label>
        <input type="radio" id="nu" name="gioi_tinh" value="2" required>
        <label for="nu">Nữ</label>

        <input type="submit" value="Thêm Tài Khoản">

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['ten_dang_nhap'];
            $password = $_POST['mat_khau'];
            $email = $_POST['email'];
            $ho_ten = $_POST['ho_ten'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $ngay_sinh = $_POST['ngay_sinh'];
            $gioi_tinh = $_POST['gioi_tinh'];

            $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, email, ho_ten, ngay_sinh, so_dien_thoai,  gioi_tinh) VALUES ('$name', '$password', '$email', '$ho_ten', '$ngay_sinh', '$so_dien_thoai',  '$gioi_tinh')";
            if(mysqli_query($conn, $sql)) {
                header("Location: index.php?page_layout=taiKhoan.php");
            } else {
                echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        
        ?>
    </form>
</body>
</html>