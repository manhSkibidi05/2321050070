<div>
    <h1>Danh sách phim</h1>
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
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT p.id, p.ten_phim, p.nam, p.quoc_gia,
                           p.do_tuoi, p.mo_ta, dd.ho_ten,
                           GROUP_CONCAT(DISTINCT tl.ten_the_loai SEPARATOR ', ') AS danh_muc
                    FROM phim p
                    JOIN dao_dien dd ON dd.id = p.dao_dien_id
                    LEFT JOIN phim_the_loai ptl ON ptl.phim_id = p.id
                    LEFT JOIN the_loai tl ON tl.id = ptl.the_loai_id
                    GROUP BY p.id, p.ten_phim, p.nam, p.quoc_gia,
                             p.do_tuoi, p.mo_ta, dd.ho_ten
                    ORDER BY p.id DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?= (int) $row['id'] ?></td>
                <td>
                    <strong><?= htmlspecialchars($row['ten_phim']) ?></strong>
                    <?php if (!empty($row['mo_ta'])): ?>
                        <br><small><?= htmlspecialchars($row['mo_ta']) ?></small>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['nam']) ?></td>
                <td><?= htmlspecialchars($row['quoc_gia']) ?></td>
                <td><?= htmlspecialchars($row['ho_ten']) ?></td>
                <td><?= (int) $row['do_tuoi'] ?>+</td>
                <td><?= htmlspecialchars($row['danh_muc'] ?? 'Chưa phân loại') ?></td>
            </tr>
        <?php
                }
            } else {
        ?>
            <tr>
                <td colspan="7">Chưa có phim nào.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>