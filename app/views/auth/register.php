<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Đăng ký tài khoản</h2>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <label>Họ tên:</label><br>
    <input type="text" name="name" required><br><br>
    <label>Mật khẩu:</label><br>
    <input type="password" name="password" required><br><br>
    <label>Vai trò:</label>
    <select name="role">
        <option value="candidate">Ứng viên</option>
        <option value="recruiter">Nhà tuyển dụng</option>
    </select><br><br>
    <button type="submit">Đăng ký</button>
</form>
<p>
    Đã có tài khoản? <a href="/login">Đăng nhập</a>
</p>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
