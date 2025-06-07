<?php
namespace App\Controllers;

use App\Models\CV;
use Libraries\GeminiClient;
use Services\PdfReaderService;

class CandidateController
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'candidate') {
            header('Location: /login');
            exit;
        }
    }

    // Trang dashboard cho ứng viên
    public function dashboard()
    {
        include __DIR__ . '/../views/candidate/dashboard.php';
    }

    // Upload CV, trích xuất nội dung PDF, gửi sang Gemini API chấm điểm & lưu vào DB
    public function uploadCV()
    {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv'])) {
            $cvModel = new CV($this->db);
            $pdfReader = new PdfReaderService();
            $gemini = new GeminiClient();

            $file = $_FILES['cv'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                if (strtolower($ext) === 'pdf') {
                    $filename = uniqid('cv_') . '.pdf';
                    $uploadDir = __DIR__ . '/../../../public/uploads/';
                    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
                    move_uploaded_file($file['tmp_name'], $uploadDir . $filename);

                    // Đọc nội dung PDF
                    $content = $pdfReader->read($uploadDir . $filename);

                    // Phân tích với AI Gemini
                    $ai = $gemini->analyzeCV($content);

                    // Lưu vào DB
                    $cvModel->save(
                        $_SESSION['user_id'],
                        'uploads/' . $filename, // Đường dẫn tương đối để download CV
                        $content,
                        $ai['score'],
                        $ai['ai_feedback'],
                        $ai['ai_position_suggestion'],
                        $ai['ai_improvement']
                    );
                    $message = "Tải lên và phân tích thành công!";
                } else {
                    $message = "Vui lòng chọn file PDF.";
                }
            } else {
                $message = "Lỗi tải file.";
            }
        }
        include __DIR__ . '/../views/candidate/upload_cv.php';
    }

    // Tạo CV tự động bằng AI Gemini
    public function generateCV()
    {
        $result = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gemini = new GeminiClient();
            $input = $_POST['info'] ?? '';
            $result = $gemini->generateCV($input);
        }
        include __DIR__ . '/../views/candidate/generate_cv.php';
    }

    // Xem feedback của recruiter cho các CV của mình
    public function viewFeedback()
    {
        $cvModel = new CV($this->db);
        $feedbacks = $cvModel->getRecruiterFeedbacks($_SESSION['user_id']);
        include __DIR__ . '/../views/candidate/view_feedback.php';
    }

    // Xem lại các CV đã upload (hiện cả feedback AI)
    public function viewCVs()
    {
        $cvModel = new CV($this->db);
        $cvs = $cvModel->getAllByUser($_SESSION['user_id']);
        include __DIR__ . '/../views/candidate/view_cvs.php';
    }

    // Xin tư vấn lộ trình nghề nghiệp từ AI Gemini
    public function careerPath()
    {
        $pathSuggest = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gemini = new GeminiClient();
            $major = $_POST['major'] ?? '';
            $pathSuggest = $gemini->suggestCareerPath($major);
        }
        include __DIR__ . '/../views/candidate/career_path.php';
    }
}
