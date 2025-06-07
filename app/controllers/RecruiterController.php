<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\CV;
use App\Models\RecruiterEvaluation;

class RecruiterController
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'recruiter') {
            header('Location: /login');
            exit;
        }
    }

    // Trang dashboard cho nhà tuyển dụng
    public function dashboard()
    {
        include __DIR__ . '/../views/recruiter/dashboard.php';
    }

    // Tìm kiếm ứng viên theo tên, email hoặc ngành/nghề
    public function searchCandidates()
    {
        $users = [];
        $query = $_GET['q'] ?? '';
        if ($query !== '') {
            $userModel = new User($this->db);
            $users = $userModel->searchCandidates($query);
        }
        include __DIR__ . '/../views/recruiter/search_candidates.php';
    }

    // Xem thống kê số lượng ứng viên, CV, lượt đánh giá, ...
    public function statistics()
    {
        $cvModel = new CV($this->db);
        $totalCVs = $cvModel->countAll();
        $totalCandidates = $cvModel->countCandidates();
        $totalEvaluations = (new RecruiterEvaluation($this->db))->countAll();
        include __DIR__ . '/../views/recruiter/statistics.php';
    }

    // Xem chi tiết CV ứng viên, đánh giá (comment + rating)
    public function viewCV()
    {
        $cvId = $_GET['id'] ?? null;
        $cv = null; $candidate = null; $evaluations = [];
        $message = '';

        if ($cvId) {
            $cvModel = new CV($this->db);
            $cv = $cvModel->getById($cvId);

            if ($cv) {
                $userModel = new User($this->db);
                $candidate = $userModel->findById($cv['user_id']);

                $evalModel = new RecruiterEvaluation($this->db);
                $evaluations = $evalModel->getByCV($cvId);

                // Xử lý đánh giá mới
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $rating = (int)($_POST['rating'] ?? 0);
                    $comment = trim($_POST['comment'] ?? '');
                    $recruiterId = $_SESSION['user_id'];
                    if ($rating && $comment) {
                        $evalModel->add($recruiterId, $cvId, $rating, $comment);
                        $message = "Đánh giá thành công!";
                        // Refresh đánh giá
                        $evaluations = $evalModel->getByCV($cvId);
                    } else {
                        $message = "Vui lòng nhập đầy đủ rating & bình luận!";
                    }
                }
            }
        }

        include __DIR__ . '/../views/recruiter/view_cv.php';
    }
}
