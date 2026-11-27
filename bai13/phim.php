<div>
    <h1>Danh sách phim</h1>
    <a class="btn" href="index.php?page_layout=themPhim.php">Thêm phim</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên phim</th>
            <th>Năm SX</th>
            <th>Quốc gia</th>
            <th>Đạo diễn</th>
            <th>Độ tuổi</th>
            <th>Danh mục</th>
            <th>Ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT p.id, p.ten_phim, p.nam, p.quoc_gia,
                           p.do_tuoi, p.mo_ta, dd.ho_ten, p.anh,
                           GROUP_CONCAT(DISTINCT tl.ten_the_loai SEPARATOR ', ') AS danh_muc
                    FROM phim p
                    JOIN dao_dien dd ON dd.id = p.dao_dien_id
                    LEFT JOIN phim_the_loai ptl ON ptl.phim_id = p.id
                    LEFT JOIN the_loai tl ON tl.id = ptl.the_loai_id
                    GROUP BY p.id, p.ten_phim, p.nam, p.quoc_gia,
                             p.do_tuoi, p.mo_ta, dd.ho_ten, p.anh
                    ORDER BY p.id DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $year = date('Y', strtotime($row['nam']));
        ?>
            <tr>
                <td><?= (int) $row['id'] ?></td>
                <td>
                    <strong><?= htmlspecialchars($row['ten_phim']) ?></strong>
                    <?php if (!empty($row['mo_ta'])): ?>
                        <br><small><?= htmlspecialchars($row['mo_ta']) ?></small>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($year) ?></td>
                <td><?= htmlspecialchars($row['quoc_gia']) ?></td>
                <td><?= htmlspecialchars($row['ho_ten']) ?></td>
                <td><?= (int) $row['do_tuoi'] ?>+</td>
                <td><?= htmlspecialchars($row['danh_muc'] ?? 'Chưa phân loại') ?></td>
                <td>
                    <?php if (!empty($row['anh']) && file_exists($row['anh'])): ?>
                        <img src="<?= htmlspecialchars($row['anh']) ?>" alt="<?= htmlspecialchars($row['ten_phim']) ?>" style="max-width: 100px; max-height: 100px;">
                    <?php else: ?>
                        <span>Chưa có ảnh</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn-update" href="index.php?page_layout=capNhatPhim.php&id=<?= (int) $row['id'] ?>">Sửa</a>
                    <a class="btn-delete" href="index.php?page_layout=xoaPhim.php&id=<?= (int) $row['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')">Xóa</a>
                </td>
            </tr>
        <?php
                }
            } else {
        ?>
            <tr><td colspan="8">Chưa có phim nào.</td></tr>
        <?php } ?>
    </tbody>
</table>