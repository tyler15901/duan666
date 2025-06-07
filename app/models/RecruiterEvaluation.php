<?php
namespace App\Models;
class RecruiterEvaluation
{
    protected $db;
    public function __construct($db) { $this->db = $db; }

    public function add($recruiterId, $cvId, $rating, $comment)
    {
        $stmt = $this->db->prepare("INSERT INTO recruiter_evaluations (recruiter_id, cv_id, rating, comment, created_at)
            VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$recruiterId, $cvId, $rating, $comment]);
    }

    public function getByCV($cvId)
    {
        $stmt = $this->db->prepare("SELECT r.*, u.name as recruiter_name
            FROM recruiter_evaluations r JOIN users u ON r.recruiter_id = u.id
            WHERE r.cv_id = ? ORDER BY r.created_at DESC");
        $stmt->execute([$cvId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM recruiter_evaluations");
        return $stmt->fetch()['total'] ?? 0;
    }
}
