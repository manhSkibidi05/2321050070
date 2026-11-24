<div>
    <h1>Danh mục phim</h1>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Số lượng phim</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT tl.id, tl.ten_the_loai,
                           COUNT(ptl.id_phim) AS so_phim
                    FROM the_loai tl
                    LEFT JOIN phim_the_loai ptl ON ptl.id_the_loai = tl.id
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
            </tr>
        <?php
                }
            } else {
        ?>
            <tr>
                <td colspan="3">Chưa có danh mục nào.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>