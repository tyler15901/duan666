<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Tư vấn lộ trình nghề nghiệp bằng AI</h2>
<form method="post">
    <label>Ngành nghề bạn quan tâm:</label><br>
    <input type="text" name="major" required><br>
    <button type="submit">Gợi ý lộ trình</button>
</form>
<?php if (!empty($pathSuggest)): ?>
    <h3>Lộ trình gợi ý:</h3>
    <p><?= nl2br(htmlspecialchars($pathSuggest)) ?></p>
<?php endif; ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
