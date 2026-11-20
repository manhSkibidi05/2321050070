<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa tài khoản</title>
</head>
<body>
    <?php 
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "DELETE FROM nguoi_dung WHERE id = $id";
            if(mysqli_query($conn, $sql)) {
                header("Location: index.php?page_layout=taiKhoan.php");
                exit;
            } else {
                echo "Lỗi khi xóa tài khoản: " . mysqli_error($conn);
            }
        } else {
            echo "ID tài khoản không hợp lệ.";
        }
    ?>
</body>
</html>