<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Đăng nhập</h2>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <label>Mật khẩu:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Đăng nhập</button>
</form>
<p>
    Chưa có tài khoản? <a href="/register">Đăng ký</a>
</p>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
