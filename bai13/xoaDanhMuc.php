<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0) {
    $conn->begin_transaction();
    try {
        $deleteLinks = $conn->prepare("DELETE FROM phim_the_loai WHERE the_loai_id = ?");
        $deleteLinks->bind_param('i', $id);
        $deleteLinks->execute();
        $deleteLinks->close();

        $deleteCategory = $conn->prepare("DELETE FROM the_loai WHERE id = ?");
        $deleteCategory->bind_param('i', $id);
        $deleteCategory->execute();
        $deleteCategory->close();
        $conn->commit();
    } catch (Throwable $error) {
        $conn->rollback();
        echo '<div class="message error">Không thể xóa danh mục: ' . htmlspecialchars($error->getMessage()) . '</div>';
        return;
    }
    header("Location: index.php?page_layout=danhMuc.php");
    exit;
}
echo '<div class="message error">ID danh mục không hợp lệ.</div>';