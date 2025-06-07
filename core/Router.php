<?php
namespace Core;

class Router
{
    public static function route($db)
    {
        // Lấy path thật sự, tự động loại bỏ tên thư mục cha (duan2/public/...)
        $baseFolder = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        if ($baseFolder && strpos($uri, $baseFolder) === 0) {
            $uri = substr($uri, strlen($baseFolder));
            $uri = ltrim($uri, '/');
        }

        // Auth
        if ($uri === 'login')           (new \App\Controllers\AuthController($db))->login();
        elseif ($uri === 'register')    (new \App\Controllers\AuthController($db))->register();
        elseif ($uri === 'logout')      (new \App\Controllers\AuthController($db))->logout();

        // Candidate
        elseif ($uri === 'candidate/dashboard')        (new \App\Controllers\CandidateController($db))->dashboard();
        elseif ($uri === 'candidate/upload_cv')        (new \App\Controllers\CandidateController($db))->uploadCV();
        elseif ($uri === 'candidate/generate_cv')      (new \App\Controllers\CandidateController($db))->generateCV();
        elseif ($uri === 'candidate/view_feedback')    (new \App\Controllers\CandidateController($db))->viewFeedback();
        elseif ($uri === 'candidate/career_path')      (new \App\Controllers\CandidateController($db))->careerPath();

        // Recruiter
        elseif ($uri === 'recruiter/dashboard')        (new \App\Controllers\RecruiterController($db))->dashboard();
        elseif ($uri === 'recruiter/search_candidates')(new \App\Controllers\RecruiterController($db))->searchCandidates();
        elseif ($uri === 'recruiter/statistics')       (new \App\Controllers\RecruiterController($db))->statistics();
        elseif ($uri === 'recruiter/view_cv')          (new \App\Controllers\RecruiterController($db))->viewCV();

        // Trang chủ
        elseif ($uri === '' || $uri === '/')           header('Location: /login');
        else {
            http_response_code(404);
            echo '<h2>404 - Không tìm thấy trang</h2>';
        }
    }
}
