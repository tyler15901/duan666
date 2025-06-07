<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Tìm kiếm ứng viên</h2>
<form method="get" action="">
    <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Nhập tên hoặc email ứng viên">
    <button type="submit">Tìm kiếm</button>
</form>

<?php if (isset($users) && is_array($users)): ?>
    <h3>Kết quả tìm kiếm:</h3>
    <?php if (count($users) > 0): ?>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Xem CV</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <a href="/recruiter/view_cv?id=<?= urlencode($u['id']) ?>">Xem CV</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Không tìm thấy ứng viên nào phù hợp.</p>
    <?php endif; ?>
<?php endif; ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
