<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM phim WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result ? $result->fetch_assoc() : null;
$stmt->close();

if (!$movie) {
    echo '<div class="message error">Không tìm thấy phim.</div>';
    return;
}

$directors = $conn->query("SELECT id, ho_ten FROM dao_dien ORDER BY ho_ten");
$categories = $conn->query("SELECT id, ten_the_loai FROM the_loai ORDER BY ten_the_loai");
$selectedCategories = [];
$selectedResult = $conn->query("SELECT the_loai_id FROM phim_the_loai WHERE phim_id = " . $id);
if ($selectedResult) {
    while ($row = $selectedResult->fetch_assoc()) {
        $selectedCategories[] = (int) $row['the_loai_id'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenPhim = trim($_POST['ten_phim'] ?? '');
    $nam = trim($_POST['nam'] ?? '');
    $quocGia = trim($_POST['quoc_gia'] ?? '');
    $daoDienId = (int) ($_POST['dao_dien_id'] ?? 0);
    $doTuoi = (int) ($_POST['do_tuoi'] ?? 0);
    $moTa = trim($_POST['mo_ta'] ?? '');
    $categoryIds = $_POST['the_loai'] ?? [];

    $conn->begin_transaction();
    try {
        $update = $conn->prepare("UPDATE phim SET ten_phim = ?, quoc_gia = ?, dao_dien_id = ?, nam = ?, do_tuoi = ?, mo_ta = ? WHERE id = ?");
        $update->bind_param('ssissii', $tenPhim, $quocGia, $daoDienId, $nam, $doTuoi, $moTa, $id);
        $update->execute();
        $update->close();

        $conn->query("DELETE FROM phim_the_loai WHERE phim_id = " . $id);
        $link = $conn->prepare("INSERT INTO phim_the_loai (phim_id, the_loai_id) VALUES (?, ?)");
        foreach ($categoryIds as $categoryId) {
            $categoryId = (int) $categoryId;
            $link->bind_param('ii', $id, $categoryId);
            $link->execute();
        }
        $link->close();
        $conn->commit();
        header("Location: index.php?page_layout=phim.php");
        exit;
    } catch (Throwable $error) {
        $conn->rollback();
        echo '<div class="message error">Không thể cập nhật phim: ' . htmlspecialchars($error->getMessage()) . '</div>';
    }
}

$namValue = date('Y-m-d', strtotime($movie['nam']));
?>

<h1>Cập nhật phim</h1>
<form action="" method="POST">
    <label for="ten_phim">Tên phim:</label>
    <input type="text" id="ten_phim" name="ten_phim" value="<?= htmlspecialchars($movie['ten_phim']) ?>" required>

    <label for="nam">Năm sản xuất:</label>
    <input type="date" id="nam" name="nam" value="<?= htmlspecialchars($namValue) ?>" required>

    <label for="quoc_gia">Quốc gia:</label>
    <input type="text" id="quoc_gia" name="quoc_gia" value="<?= htmlspecialchars($movie['quoc_gia']) ?>" required>

    <label for="dao_dien_id">Đạo diễn:</label>
    <select id="dao_dien_id" name="dao_dien_id" required>
        <?php if ($directors): while ($director = $directors->fetch_assoc()): ?>
            <option value="<?= (int) $director['id'] ?>" <?= (int) $director['id'] === (int) $movie['dao_dien_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($director['ho_ten']) ?>
            </option>
        <?php endwhile; endif; ?>
    </select>

    <label for="do_tuoi">Độ tuổi:</label>
    <input type="text" id="do_tuoi" name="do_tuoi" value="<?= (int) $movie['do_tuoi'] ?>" required>

    <label for="mo_ta">Mô tả:</label>
    <input type="text" id="mo_ta" name="mo_ta" value="<?= htmlspecialchars($movie['mo_ta']) ?>" required>

    <label>Danh mục:</label>
    <?php if ($categories): while ($category = $categories->fetch_assoc()): ?>
        <input type="checkbox" id="category<?= (int) $category['id'] ?>" name="the_loai[]" value="<?= (int) $category['id'] ?>" <?= in_array((int) $category['id'], $selectedCategories, true) ? 'checked' : '' ?>>
        <label for="category<?= (int) $category['id'] ?>"><?= htmlspecialchars($category['ten_the_loai']) ?></label>
    <?php endwhile; endif; ?>

    <input type="submit" value="Cập nhật">
</form>