<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0) {
    $conn->begin_transaction();
    try {
        $deleteLinks = $conn->prepare("DELETE FROM phim_the_loai WHERE phim_id = ?");
        $deleteLinks->bind_param('i', $id);
        $deleteLinks->execute();
        $deleteLinks->close();

        $deleteMovie = $conn->prepare("DELETE FROM phim WHERE id = ?");
        $deleteMovie->bind_param('i', $id);
        $deleteMovie->execute();
        $deleteMovie->close();
        $conn->commit();
    } catch (Throwable $error) {
        $conn->rollback();
        echo '<div class="message error">Không thể xóa phim: ' . htmlspecialchars($error->getMessage()) . '</div>';
        return;
    }
    header("Location: index.php?page_layout=phim.php");
    exit;
}
echo '<div class="message error">ID phim không hợp lệ.</div>';