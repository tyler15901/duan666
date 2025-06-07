<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2>Lịch sử đánh giá của nhà tuyển dụng</h2>
<?php if (empty($feedbacks)): ?>
    <p>Chưa có phản hồi nào từ nhà tuyển dụng.</p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>File CV</th>
            <th>Nhà tuyển dụng</th>
            <th>Rating</th>
            <th>Bình luận</th>
            <th>Thời gian</th>
        </tr>
        <?php foreach ($feedbacks as $fb): ?>
        <tr>
            <td><?= htmlspecialchars($fb['file_path']) ?></td>
            <td><?= htmlspecialchars($fb['recruiter_name']) ?></td>
            <td><?= htmlspecialchars($fb['rating']) ?></td>
            <td><?= nl2br(htmlspecialchars($fb['comment'])) ?></td>
            <td><?= htmlspecialchars($fb['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
