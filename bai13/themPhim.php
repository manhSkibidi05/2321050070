<?php
$directors = $conn->query("SELECT id, ho_ten FROM dao_dien ORDER BY ho_ten");
$categories = $conn->query("SELECT id, ten_the_loai FROM the_loai ORDER BY ten_the_loai");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenPhim = trim($_POST['ten_phim'] ?? '');
    $nam = trim($_POST['nam'] ?? '');
    $quocGia = trim($_POST['quoc_gia'] ?? '');
    $daoDienId = (int) ($_POST['dao_dien_id'] ?? 0);
    $doTuoi = (int) ($_POST['do_tuoi'] ?? 0);
    $moTa = trim($_POST['mo_ta'] ?? '');
    $categoryIds = $_POST['the_loai'] ?? [];

    if ($tenPhim !== '' && $nam !== '' && $daoDienId > 0) {
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("INSERT INTO phim (ten_phim, quoc_gia, dao_dien_id, nam, do_tuoi, mo_ta) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssissi', $tenPhim, $quocGia, $daoDienId, $nam, $doTuoi, $moTa);
            $stmt->execute();
            $phimId = $stmt->insert_id;
            $stmt->close();

            $link = $conn->prepare("INSERT INTO phim_the_loai (phim_id, the_loai_id) VALUES (?, ?)");
            foreach ($categoryIds as $categoryId) {
                $categoryId = (int) $categoryId;
                $link->bind_param('ii', $phimId, $categoryId);
                $link->execute();
            }
            $link->close();
            $conn->commit();
            header("Location: index.php?page_layout=phim.php");
            exit;
        } catch (Throwable $error) {
            $conn->rollback();
            echo '<div class="message error">Không thể thêm phim: ' . htmlspecialchars($error->getMessage()) . '</div>';
        }
    }
}
?>

<h1>Thêm phim</h1>
<form action="" method="POST">
    <label for="ten_phim">Tên phim:</label>
    <input type="text" id="ten_phim" name="ten_phim" required>

    <label for="nam">Năm sản xuất:</label>
    <input type="date" id="nam" name="nam" required>

    <label for="quoc_gia">Quốc gia:</label>
    <input type="text" id="quoc_gia" name="quoc_gia" required>

    <label for="dao_dien_id">Đạo diễn:</label>
    <select id="dao_dien_id" name="dao_dien_id" required>
        <option value="">-- Chọn đạo diễn --</option>
        <?php if ($directors): while ($director = $directors->fetch_assoc()): ?>
            <option value="<?= (int) $director['id'] ?>"><?= htmlspecialchars($director['ho_ten']) ?></option>
        <?php endwhile; endif; ?>
    </select>

    <label for="do_tuoi">Độ tuổi:</label>
    <input type="text" id="do_tuoi" name="do_tuoi" required>

    <label for="mo_ta">Mô tả:</label>
    <input type="text" id="mo_ta" name="mo_ta" required>

    <label>Danh mục:</label>
    <?php if ($categories): while ($category = $categories->fetch_assoc()): ?>
        <input type="checkbox" id="category<?= (int) $category['id'] ?>" name="the_loai[]" value="<?= (int) $category['id'] ?>">
        <label for="category<?= (int) $category['id'] ?>"><?= htmlspecialchars($category['ten_the_loai']) ?></label>
    <?php endwhile; endif; ?>

    <input type="submit" value="Thêm phim">
</form>