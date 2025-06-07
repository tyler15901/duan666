<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Thống kê hệ thống</h2>
<ul>
    <li>Tổng số CV: <b><?= htmlspecialchars($totalCVs) ?></b></li>
    <li>Tổng số ứng viên: <b><?= htmlspecialchars($totalCandidates) ?></b></li>
    <li>Tổng số lượt đánh giá: <b><?= htmlspecialchars($totalEvaluations) ?></b></li>
</ul>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
