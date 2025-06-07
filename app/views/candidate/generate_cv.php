<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Tạo CV tự động bằng AI</h2>
<form method="post">
    <label>Thông tin của bạn:</label><br>
    <textarea name="info" rows="6" cols="60" required></textarea><br>
    <button type="submit">Tạo CV</button>
</form>
<?php if (!empty($result)): ?>
    <h3>Kết quả CV mẫu:</h3>
    <pre><?= htmlspecialchars($result) ?></pre>
<?php endif; ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
