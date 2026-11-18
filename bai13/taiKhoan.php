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
        div{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        a.btn{
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Danh sách Tài khoản</h1>
        <a class="btn" href="themTaiKhoan.php">Thêm Tài Khoản</a>
    </div>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Ngày sinh</th>
        </tr>
        <tr>
            <?php
                $sql = "SELECT * FROM nguoi_dung";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row['ten_dang_nhap']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['ho_ten']; ?></td>
                <td><?php echo $row['so_dien_thoai']; ?></td>
                <td><?php echo $row['ngay_sinh']; ?></td>
            </tr>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>No accounts found</td></tr>";
                }
            ?>
        </tr>
    </table>

</body>
</html>