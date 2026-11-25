<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare("SELECT ten_the_loai FROM the_loai WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$category) {
    echo '<div class="message error">Không tìm thấy danh mục.</div>';
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenTheLoai = trim($_POST['ten_the_loai'] ?? '');
    if ($tenTheLoai !== '') {
        $update = $conn->prepare("UPDATE the_loai SET ten_the_loai = ? WHERE id = ?");
        $update->bind_param('si', $tenTheLoai, $id);
        if ($update->execute()) {
            $update->close();
            header("Location: index.php?page_layout=danhMuc.php");
            exit;
        }
        echo '<div class="message error">Không thể cập nhật danh mục: ' . htmlspecialchars($conn->error) . '</div>';
        $update->close();
    }
}
?>

<h1>Cập nhật danh mục</h1>
<form action="" method="POST">
    <label for="ten_the_loai">Tên danh mục:</label>
    <input type="text" id="ten_the_loai" name="ten_the_loai" value="<?= htmlspecialchars($category['ten_the_loai']) ?>" required>
    <input type="submit" value="Cập nhật">
</form>