<h1>Tổng quan</h1>

<div class="admin-grid">
    <?php
        $stats = [
            ['Tài khoản', 'nguoi_dung'],
            ['Danh mục', 'the_loai'],
            ['Phim', 'phim'],
            ['Đạo diễn', 'dao_dien'],
            ['Diễn viên', 'dien_vien'],
        ];

        foreach ($stats as [$label, $table]) {
            $count = 0;
            $countResult = $conn->query("SELECT COUNT(*) AS total FROM `{$table}`");
            if ($countResult) {
                $countRow = $countResult->fetch_assoc();
                $count = (int) ($countRow['total'] ?? 0);
            }
    ?>
        <section class="stat-card">
            <span class="stat-label"><?= htmlspecialchars($label) ?></span>
            <strong class="stat-number"><?= $count ?></strong>
        </section>
    <?php } ?>
</div>