<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Đánh giá CV cá nhân</h2>
<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
    <label>Chọn file CV (PDF):</label><br>
    <input type="file" name="cv" accept="application/pdf" required><br><br>
    <button type="submit">Upload & Phân tích AI</button>
</form>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
