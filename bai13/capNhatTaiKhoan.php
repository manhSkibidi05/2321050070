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
    <title>Cập nhật tài khoản</title>
</head>
<body>
    <?php
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM nguoi_dung WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "Không tìm thấy tài khoản.";
                exit;
            }
        } else {
            echo "ID tài khoản không hợp lệ.";
            exit;
        }
    ?>
    <h1>Cập nhật tài khoản</h1>
    <form action="" method="POST">
        <label for="ten_dang_nhap">Tên đăng nhập:</label>
        <input type="text" id="ten_dang_nhap" name="ten_dang_nhap" value="<?php echo $row['ten_dang_nhap']; ?>" required><br><br>

        <label for="mat_khau">Mật khẩu:</label>
        <input type="text" id="mat_khau" name="mat_khau" value="<?php echo $row['mat_khau']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>

        <label for="ho_ten">Họ tên:</label>
        <input type="text" id="ho_ten" name="ho_ten" value="<?php echo $row['ho_ten']; ?>" required><br><br>

        <label for="so_dien_thoai">Số điện thoại:</label>
        <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="<?php echo $row['so_dien_thoai']; ?>" required><br><br>

        <label for="ngay_sinh">Ngày sinh:</label>
        <input type="date" id="ngay_sinh" name="ngay_sinh" value="<?php echo $row['ngay_sinh']; ?>" required><br><br>

        <input type="submit" name="submit" value="Cập nhật">
    </form>
    <?php
        if(isset($_POST['submit'])) {
            $ten_dang_nhap = $_POST['ten_dang_nhap'];
            $mat_khau = $_POST['mat_khau'];
            $email = $_POST['email'];
            $ho_ten = $_POST['ho_ten'];
            $so_dien_thoai = $_POST['so_dien_thoai'];
            $ngay_sinh = $_POST['ngay_sinh'];

            $sql_update = "UPDATE nguoi_dung SET ten_dang_nhap='$ten_dang_nhap', mat_khau='$mat_khau', email='$email', ho_ten='$ho_ten', so_dien_thoai='$so_dien_thoai', ngay_sinh='$ngay_sinh' WHERE id=$id";
            if(mysqli_query($conn, $sql_update)) {
                echo "Cập nhật tài khoản thành công.";
                header("Location: index.php?page_layout=taiKhoan.php");
                exit;
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }
        }
    ?>
</body>
</html>