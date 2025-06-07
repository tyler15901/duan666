<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php if ($cv && $candidate): ?>
    <h2>CV của ứng viên: <?= htmlspecialchars($candidate['name']) ?></h2>
    <p><b>File CV:</b> <a href="/<?= htmlspecialchars($cv['file_path']) ?>" target="_blank">Tải về</a></p>
    <p><b>Điểm AI:</b> <?= htmlspecialchars($cv['score']) ?></p>
    <p><b>Feedback AI:</b> <?= nl2br(htmlspecialchars($cv['ai_feedback'])) ?></p>
    <p><b>Gợi ý vị trí:</b> <?= nl2br(htmlspecialchars($cv['ai_position_suggestion'])) ?></p>
    <p><b>Cải thiện:</b> <?= nl2br(htmlspecialchars($cv['ai_improvement'])) ?></p>
    <hr>
    <h3>Đánh giá CV</h3>
    <?php if (!empty($message)): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Rating (1-5): <input type="number" name="rating" min="1" max="5" required></label><br>
        <label>Bình luận:</label><br>
        <textarea name="comment" rows="3" cols="50" required></textarea><br>
        <button type="submit">Gửi đánh giá</button>
    </form>
    <hr>
    <h3>Lịch sử đánh giá</h3>
    <?php if ($evaluations): ?>
        <ul>
        <?php foreach ($evaluations as $eval): ?>
            <li>
                <b><?= htmlspecialchars($eval['recruiter_name']) ?></b>
                (<?= htmlspecialchars($eval['created_at']) ?>): 
                <b><?= htmlspecialchars($eval['rating']) ?>/5</b>
                <br><?= nl2br(htmlspecialchars($eval['comment'])) ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Chưa có đánh giá nào!</p>
    <?php endif; ?>
<?php else: ?>
    <p>Không tìm thấy CV này.</p>
<?php endif; ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
