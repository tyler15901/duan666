<?php
namespace App\Models;
class CV
{
    protected $db;
    public function __construct($db) { $this->db = $db; }

    public function save($userId, $filePath, $content, $score = null, $ai_feedback = null, $ai_position_suggestion = null, $ai_improvement = null)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO cvs (user_id, file_path, content, score, ai_feedback, ai_position_suggestion, ai_improvement, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([$userId, $filePath, $content, $score, $ai_feedback, $ai_position_suggestion, $ai_improvement]);
    }

    public function getAllByUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM cvs WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRecruiterFeedbacks($userId)
    {
        $stmt = $this->db->prepare(
            "SELECT e.*, u.name as recruiter_name, c.file_path
            FROM recruiter_evaluations e
            JOIN cvs c ON e.cv_id = c.id
            JOIN users u ON e.recruiter_id = u.id
            WHERE c.user_id = ?
            ORDER BY e.created_at DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function countAll()
{
    $stmt = $this->db->query("SELECT COUNT(*) as total FROM cvs");
    return $stmt->fetch()['total'] ?? 0;
}
public function countCandidates()
{
    $stmt = $this->db->query("SELECT COUNT(DISTINCT user_id) as total FROM cvs");
    return $stmt->fetch()['total'] ?? 0;
}
public function getById($cvId)
{
    $stmt = $this->db->prepare("SELECT * FROM cvs WHERE id = ?");
    $stmt->execute([$cvId]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

}
