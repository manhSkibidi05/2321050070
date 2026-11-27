<?php
$directors = $conn->query("SELECT id, ho_ten FROM dao_dien ORDER BY ho_ten");
$categories = $conn->query("SELECT id, ten_the_loai FROM the_loai ORDER BY ten_the_loai");

$errors = [];
$anhPath = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenPhim = trim($_POST['ten_phim'] ?? '');
    $namInput = trim($_POST['nam'] ?? '');
    $quocGia = trim($_POST['quoc_gia'] ?? '');
    $daoDienId = (int) ($_POST['dao_dien_id'] ?? 0);
    $doTuoi = (int) ($_POST['do_tuoi'] ?? 0);
    $moTa = trim($_POST['mo_ta'] ?? '');
    $categoryIds = $_POST['the_loai'] ?? [];

    // Chuyển giá trị năm sang số nguyên (ví dụ: "2026" hoặc "2026-11-27" -> 2026)
    $nam = 0;
    if (preg_match('/^\d{4}$/', $namInput)) {
        $nam = (int) $namInput;
    } elseif (preg_match('/^(\d{4})-\d{2}-\d{2}$/', $namInput, $m)) {
        $nam = (int) $m[1];
    } elseif (preg_match('/^\d{2}\/\d{2}\/(\d{4})$/', $namInput, $m)) {
        $nam = (int) $m[1];
    }

    // Xử lý upload ảnh nếu có chọn file
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['fileToUpload']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Lỗi tải file lên server (mã lỗi: " . $_FILES['fileToUpload']['error'] . ").";
        } else {
            $target_dir = "upload/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $originalName = basename($_FILES['fileToUpload']['name']);
            $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
            if ($check === false) {
                $errors[] = "File không phải là ảnh hợp lệ.";
            }

            if (!in_array($imageFileType, $allowedTypes, true)) {
                $errors[] = "Chỉ chấp nhận các định dạng ảnh: JPG, JPEG, PNG, GIF.";
            }

            if ($_FILES['fileToUpload']['size'] > 5 * 1024 * 1024) {
                $errors[] = "Kích thước ảnh tối đa là 5MB.";
            }

            if (empty($errors)) {
                $newFileName = uniqid('phim_', true) . '.' . $imageFileType;
                $target_file = $target_dir . $newFileName;

                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
                    $anhPath = $target_file;
                } else {
                    $errors[] = "Không thể lưu ảnh vào thư mục upload/.";
                }
            }
        }
    }

    if ($tenPhim === '' || $nam < 1900 || $nam > 2100 || $daoDienId <= 0) {
        $errors[] = "Vui lòng nhập đầy đủ Tên phim, Năm sản xuất hợp lệ (1900–2100) và chọn Đạo diễn.";
    }

    if (empty($errors)) {
        $conn->begin_transaction();
        try {
            // nam là số nguyên nên bind_param dùng 'i' (ssiiisi)
            $stmt = $conn->prepare("
                INSERT INTO phim (ten_phim, quoc_gia, dao_dien_id, nam, do_tuoi, mo_ta, anh)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param('ssiiiss', $tenPhim, $quocGia, $daoDienId, $nam, $doTuoi, $moTa, $anhPath);
            $stmt->execute();
            $phimId = $stmt->insert_id;
            $stmt->close();

            if (!empty($categoryIds)) {
                $link = $conn->prepare("INSERT INTO phim_the_loai (phim_id, the_loai_id) VALUES (?, ?)");
                foreach ($categoryIds as $categoryId) {
                    $categoryId = (int) $categoryId;
                    if ($categoryId > 0) {
                        $link->bind_param('ii', $phimId, $categoryId);
                        $link->execute();
                    }
                }
                $link->close();
            }

            $conn->commit();
            header("Location: index.php?page_layout=phim.php");
            exit;
        } catch (Throwable $error) {
            $conn->rollback();
            if ($anhPath && file_exists($anhPath)) {
                unlink($anhPath);
            }
            $errors[] = "Không thể thêm phim: " . $error->getMessage();
        }
    }
}
?>

<h1>Thêm phim</h1>

<?php if (!empty($errors)): ?>
    <div class="message error">
        <?php foreach ($errors as $err): ?>
            <p><?= htmlspecialchars($err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
    <label for="ten_phim">Tên phim:</label>
    <input type="text" id="ten_phim" name="ten_phim" value="<?= htmlspecialchars($tenPhim ?? '') ?>" required>

    <label for="nam">Năm sản xuất:</label>
    <input type="number" id="nam" name="nam" min="1900" max="2100" placeholder="Ví dụ: 2026"
           value="<?= htmlspecialchars((string) ($namInput ?? '')) ?>" required>

    <label for="quoc_gia">Quốc gia:</label>
    <input type="text" id="quoc_gia" name="quoc_gia" value="<?= htmlspecialchars($quocGia ?? '') ?>" required>

    <label for="dao_dien_id">Đạo diễn:</label>
    <select id="dao_dien_id" name="dao_dien_id" required>
        <option value="">-- Chọn đạo diễn --</option>
        <?php if ($directors): while ($director = $directors->fetch_assoc()): ?>
            <option value="<?= (int) $director['id'] ?>" <?= (($daoDienId ?? 0) === (int) $director['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($director['ho_ten']) ?>
            </option>
        <?php endwhile; endif; ?>
    </select>

    <label for="do_tuoi">Độ tuổi:</label>
    <input type="number" id="do_tuoi" name="do_tuoi" min="0" max="21" value="<?= htmlspecialchars((string) ($doTuoi ?? '')) ?>" required>

    <label for="mo_ta">Mô tả:</label>
    <input type="text" id="mo_ta" name="mo_ta" value="<?= htmlspecialchars($moTa ?? '') ?>" required>

    <label>Danh mục:</label>
    <?php if ($categories): while ($category = $categories->fetch_assoc()): ?>
        <?php $catId = (int) $category['id']; ?>
        <input type="checkbox" id="category<?= $catId ?>" name="the_loai[]" value="<?= $catId ?>"
            <?= in_array($catId, array_map('intval', $categoryIds ?? []), true) ? 'checked' : '' ?>>
        <label for="category<?= $catId ?>"><?= htmlspecialchars($category['ten_the_loai']) ?></label>
    <?php endwhile; endif; ?>

    <label for="fileToUpload">Chọn ảnh:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg,.jpeg,.png,.gif">

    <input type="submit" value="Thêm phim">
</form>