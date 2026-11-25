<h1>Thêm danh mục</h1>
<form action="" method="POST">
    <label for="ten_the_loai">Tên danh mục:</label>
    <input type="text" id="ten_the_loai" name="ten_the_loai" required>
    <input type="submit" value="Thêm danh mục">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenTheLoai = trim($_POST['ten_the_loai'] ?? '');
    if ($tenTheLoai !== '') {
        $stmt = $conn->prepare("INSERT INTO the_loai (ten_the_loai) VALUES (?)");
        $stmt->bind_param('s', $tenTheLoai);
        if ($stmt->execute()) {
            header("Location: index.php?page_layout=danhMuc.php");
            exit;
        }
        echo '<div class="message error">Không thể thêm danh mục: ' . htmlspecialchars($conn->error) . '</div>';
        $stmt->close();
    }
}
?>