<?php
namespace App\Models;
class Candidate
{
    protected $db;
    public function __construct($db) { $this->db = $db; }
    // Bạn có thể bổ sung function lấy profile, cập nhật profile ở đây nếu muốn
}
