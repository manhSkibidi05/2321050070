<?php
    session_start();
    include 'connect.php';
?>
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
        nav {
            background-color: #333;
            overflow: hidden;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 10px;
        }
        nav ul li {
            float: left;
        }
        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        nav ul li a:hover {
            background-color: #111;
        }
    </style>
    <link rel="stylesheet" href="admin.css">
    <title>Quản trị Cinema</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?page_layout=trangChu.php">Trang chủ</a></li>
            <li><a href="index.php?page_layout=taiKhoan.php">Tài khoản</a></li>
            <li><a href="index.php?page_layout=danhMuc.php">Danh mục</a></li>
            <li><a href="index.php?page_layout=phim.php">Phim</a></li>
        </ul>
    </nav>
    <?php 
        if(isset($_GET['page_layout'])) {
            switch($_GET['page_layout']) {
                case 'trangChu.php':
                    include 'trangChu.php';
                    break;
                case 'taiKhoan.php':
                    include 'taiKhoan.php';
                    break;
                case 'danhMuc.php':
                    include 'danhMuc.php';
                    break;
                case 'phim.php':
                    include 'phim.php';
                    break;
                case 'themTaiKhoan.php':
                    include 'themTaiKhoan.php';
                    break;
                case 'xoaTaiKhoan.php':
                    include 'xoaTaiKhoan.php';
                    break; 
                case 'capNhatTaiKhoan.php':
                    include 'capNhatTaiKhoan.php';
                    break;
                case 'themDanhMuc.php':
                    include 'themDanhMuc.php';
                    break;
                case 'xoaDanhMuc.php':
                    include 'xoaDanhMuc.php';
                    break;
                case 'capNhatDanhMuc.php':
                    include 'capNhatDanhMuc.php';
                    break;
                case 'themPhim.php':
                    include 'themPhim.php';
                    break;
                case 'xoaPhim.php':
                    include 'xoaPhim.php';
                    break;
                case 'capNhatPhim.php':
                    include 'capNhatPhim.php';
                    break;
                default:
                    include 'trangChu.php';
            }
        } else {
            include 'trangChu.php';
        }
    ?>
</body>
</html>