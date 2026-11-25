<div>
    <h1>Danh mục phim</h1>
    <a class="btn" href="index.php?page_layout=themDanhMuc.php">Thêm danh mục</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Số lượng phim</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT tl.id, tl.ten_the_loai,
                           COUNT(ptl.id) AS so_phim
                    FROM the_loai tl
                    LEFT JOIN phim_the_loai ptl ON ptl.the_loai_id = tl.id
                    GROUP BY tl.id, tl.ten_the_loai
                    ORDER BY tl.ten_the_loai";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?= (int) $row['id'] ?></td>
                <td><?= htmlspecialchars($row['ten_the_loai']) ?></td>
                <td><?= (int) $row['so_phim'] ?></td>
                <td>
                    <a class="btn-update" href="index.php?page_layout=capNhatDanhMuc.php&id=<?= (int) $row['id'] ?>">Sửa</a>
                    <a class="btn-delete" href="index.php?page_layout=xoaDanhMuc.php&id=<?= (int) $row['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">Xóa</a>
                </td>
            </tr>
        <?php
                }
            } else {
        ?>
            <tr><td colspan="4">Chưa có danh mục nào.</td></tr>
        <?php } ?>
    </tbody>
</table>