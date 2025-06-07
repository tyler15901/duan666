<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Xin chào, <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
<ul>
    <li><a href="/candidate/upload_cv">Đánh giá CV cá nhân</a></li>
    <li><a href="/candidate/view_feedback">Lịch sử đánh giá của nhà tuyển dụng</a></li>
    <li><a href="/candidate/generate_cv">Tạo CV tự động bằng AI</a></li>
    <li><a href="/candidate/career_path">Tư vấn lộ trình nghề nghiệp</a></li>
</ul>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
